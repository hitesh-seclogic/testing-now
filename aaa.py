import yaml
import requests

# ❌ Hardcoded AWS credentials (secret)
AWS_ACCESS_KEY = "AKIAIOSFODNN7EXAMPLE"
AWS_SECRET_KEY = "wJalrXUtnFEMI/K7MDENG/bPxRfiCYEXAMPLEKEY"
GITHUB_WEBHOOK_SECRET="LbpB1e60Dz1XBaP9C1gymdl3jgJ5Cg"

# ✅ Safe usage
def safe_yaml_load(yaml_str):
    return yaml.safe_load(yaml_str)

# ❌ Vulnerable usage (CVE-2017-18342)
def unsafe_yaml_load(yaml_str):
    return yaml.load(yaml_str)  # Vulnerability: unsafe loading

# Example YAML
example_yaml = """
a: 1
b: 2
c: 3
"""

# ❌ Example: make insecure HTTP request
def fetch_insecure_data():
    response = requests.get("http://example.com/api")  # no HTTPS
    return response.text

if __name__ == "__main__":
    print("Parsing YAML...")
    data = unsafe_yaml_load(example_yaml)
    print("Data:", data)
