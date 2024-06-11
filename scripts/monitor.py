import os
import re
import subprocess
import datetime
from slack_sdk import WebClient
from slack_sdk.errors import SlackApiError
from dotenv import load_dotenv

load_dotenv()

slack_token = os.getenv("SLACK_API_TOKEN")
channel_id = "C06H4R8FYD7"
basic_auth_user = "siteadmin"
basic_auth_password = "PrivetUra"

client = WebClient(token=slack_token)
state_file = '/home/bot/scripts/logs/site_state.txt'

def log_message(message):
    """Helper function to append logs to a file."""
    with open('/home/bot/scripts/logs/log.txt', 'a') as log_file:
        formatted_time = datetime.datetime.now().strftime('%Y-%m-%d %H:%M:%S')
        log_file.write(f"{formatted_time} - {message}\n")

def read_state():
    """Read the last known state of the website."""
    if not os.path.exists(state_file):
        return {'status': 'up', 'last_error_time': None}

    with open(state_file, 'r') as file:
        data = file.read().strip().split(',')
        return {'status': data[0], 'last_error_time': datetime.datetime.strptime(data[1], '%Y-%m-%d %H:%M:%S') if data[1] != 'None' else None}

def write_state(status, last_error_time):
    """Write the current state of the website."""
    with open(state_file, 'w') as file:
        file.write(f"{status},{last_error_time.strftime('%Y-%m-%d %H:%M:%S') if last_error_time else 'None'}")

def check_website():
    current_time = datetime.datetime.now()
    state = read_state()

    try:
        # Выполняем curl для получения содержимого страницы
        result = subprocess.run(
            ['curl', '-s', '-u', f'{basic_auth_user}:{basic_auth_password}', 'https://craftedcabinetdoors.com'],
            capture_output=True,
            text=True
        )
        page_content = result.stdout

        # Проверяем наличие текста id="trending" с использованием регулярного выражения
        if re.search(r'id\s*=\s*["\']trending["\']', page_content):
            if state['status'] == 'down':
                send_slack_message("Website is back up: id='trending' found.")
            write_state('up', None)
        else:
            handle_website_down(current_time, state)
    except Exception as e:
        log_message(f"Error checking website: {e}")
        handle_website_down(current_time, state)

def handle_website_down(current_time, state):
    if state['status'] == 'up' or (state['last_error_time'] and (current_time - state['last_error_time']).total_seconds() >= 3600):
        send_slack_message("Website check failed: id='trending' not found.")
        write_state('down', current_time)
    else:
        write_state('down', state['last_error_time'])

def send_slack_message(message):
    try:
        response = client.chat_postMessage(
            channel=channel_id,
            text=message
        )
        assert response["message"]["text"] == message
    except SlackApiError as e:
        log_message(f"Ошибка при отправке сообщения: {e.response['error']}")

# Выполняем проверку сайта
check_website()
