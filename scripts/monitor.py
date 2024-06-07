import os
from slack_sdk import WebClient
from slack_sdk.errors import SlackApiError
from dotenv import load_dotenv
import datetime

load_dotenv()  # Загрузка переменных окружения из .env файла

slack_token = os.getenv("SLACK_API_TOKEN")
channel_id = "C06H4R8FYD7"

client = WebClient(token=slack_token)

def log_message(message):
    """Helper function to append logs to a file."""
    print(message)
    with open('/home/bot/scripts/logs/log.txt', 'a') as log_file:
        formatted_time = datetime.datetime.now().strftime('%Y-%m-%d %H:%M:%S')
        log_file.write(f"{formatted_time} - {message}\n")

try:
    response = client.chat_postMessage(
        channel=channel_id,
        text="Hello, Slack!"
    )
    assert response["message"]["text"] == "Hello, Slack!"
except SlackApiError as e:
    log_message(f"Ошибка при отправке сообщения: {e.response['error']}")
