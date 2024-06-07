import os
import re
import subprocess
from slack_sdk import WebClient
from slack_sdk.errors import SlackApiError
from dotenv import load_dotenv
import datetime

load_dotenv()

slack_token = os.getenv("SLACK_API_TOKEN")
channel_id = "C06H4R8FYD7"
basic_auth_user = "siteadmin"
basic_auth_password = "PrivetUra"

client = WebClient(token=slack_token)

def log_message(message):
    """Helper function to append logs to a file."""
    with open('/home/bot/scripts/logs/log.txt', 'a') as log_file:
        formatted_time = datetime.datetime.now().strftime('%Y-%m-%d %H:%M:%S')
        log_file.write(f"{formatted_time} - {message}\n")

def check_website():
    try:
        # Выполняем curl для получения содержимого страницы
        result = subprocess.run(
            ['curl', '-s', '-u', f'{basic_auth_user}:{basic_auth_password}', 'https://craftedcabinetdoors.com'],
            capture_output=True,
            text=True
        )
        page_content = result.stdout

        # Логируем содержимое страницы для диагностики
        with open('/home/bot/scripts/logs/page_content.html', 'w') as log_file:
            log_file.write(page_content)

        # Проверяем наличие текста id="trending" с использованием регулярного выражения
        if not re.search(r'id\s*=\s*["\']trending["\']', page_content):
            #send_slack_message("Website check failed: id='trending' not found.")
            log_message("Website check failed: id='trending' not found.")
        else:
            log_message("Website check passed: id='trending' found.")
    except Exception as e:
        log_message(f"Error checking website: {e}")

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
