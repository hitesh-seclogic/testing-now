import os
import subprocess
import requests
import sqlite3

# 🚨 Hardcoded secrets (API key, password)
AWS_SECRET_ACCESS_KEY = "wJalrXUtnFEMI/K7MDENG/bPxRfiCYEXAMPLEKEY"
DB_PASSWORD = "supersecret123"
GITHUB_TOKEN = "ghp_1234567890abcdef1234567890abcdef1234"

# 🚨 Insecure usage of eval
user_input = input("Enter your name: ")
print("Hello " + eval("user_input"))

# 🚨 Insecure subprocess execution
cmd = input("Enter a shell command: ")
subprocess.call(cmd, shell=True)

# 🚨 HTTP request without SSL verification
response = requests.get("https://expired.badssl.com/", verify=False)
print("Fetched status:", response.status_code)

# 🚨 SQL Injection risk
username = input("Enter username: ")
conn = sqlite3.connect("users.db")
cursor = conn.cursor()
query = f"SELECT * FROM users WHERE username = '{username}'"
cursor.execute(query)
print("User info:", cursor.fetchall())

# 🚨 Weak cryptographic function
import hashlib
password = "mypassword"
hashed = hashlib.md5(password.encode()).hexdigest()
print("MD5 hash of password:", hashed)

# 🚨 Exposing secret through environment variable
os.environ["SECRET_KEY"] = "dontstoresecretslikethis"

