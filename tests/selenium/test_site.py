import os
import sys
import time
from urllib.request import urlopen

from selenium import webdriver
from selenium.common.exceptions import WebDriverException
from selenium.webdriver import ChromeOptions
from selenium.webdriver.common.by import By
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.support.ui import WebDriverWait


BASE_URL = os.environ.get("BASE_URL", "http://127.0.0.1:8087").rstrip("/")
APP_HEALTH_URL = os.environ.get("APP_HEALTH_URL", BASE_URL).rstrip("/")
SELENIUM_URL = os.environ.get("SELENIUM_REMOTE_URL", "http://127.0.0.1:4444/wd/hub")

LANGUAGES = {
    "fr": {
        "html": "fr-BE",
        "faq": "Questions fréquentes",
        "dossiers": "Dossiers",
        "slogan": "L’agriculture wallonne expliquée",
        "faq_title": "Questions fréquentes",
    },
    "en": {
        "html": "en-BE",
        "faq": "Questions",
        "dossiers": "Topics",
        "slogan": "Walloon agriculture explained",
        "faq_title": "Frequently asked questions",
    },
    "ge": {
        "html": "de-BE",
        "faq": "Fragen",
        "dossiers": "Themen",
        "slogan": "Landwirtschaft in der Wallonie verständlich erklärt",
        "faq_title": "Häufige Fragen",
    },
    "nl": {
        "html": "nl-BE",
        "faq": "Vragen",
        "dossiers": "Thema’s",
        "slogan": "Waalse landbouw uitgelegd",
        "faq_title": "Veelgestelde vragen",
    },
}

MAIN_PAGES = ["accueil", "filieres", "ressources", "dossiers", "faq", "glossaire"]
DETAIL_PAGES = [
    "page=ressource&resource=visites-pedagogiques",
    "page=dossier&dossier=eau-sols-secheresse&chapitre=reserve-eau-sol",
    "page=glossaire&term=agriculture-biologique",
]


def wait_for_http(url: str, label: str, timeout: int = 45) -> None:
    deadline = time.time() + timeout
    last_error = None
    while time.time() < deadline:
        try:
            with urlopen(url, timeout=4) as response:
                if 200 <= response.status < 500:
                    return
        except Exception as exc:  # noqa: BLE001 - diagnostic retained for timeout.
            last_error = exc
        time.sleep(1)
    raise RuntimeError(f"{label} did not become reachable at {url}: {last_error}")


def assert_text_contains(haystack: str, needle: str, context: str) -> None:
    if needle not in haystack:
        raise AssertionError(f"{context}: expected to find {needle!r} in {haystack!r}")


def assert_equal(actual: str, expected: str, context: str) -> None:
    if actual != expected:
        raise AssertionError(f"{context}: expected {expected!r}, got {actual!r}")


def open_path(driver: webdriver.Remote, path: str) -> None:
    driver.get(f"{BASE_URL}/{path.lstrip('/')}")
    WebDriverWait(driver, 15).until(EC.presence_of_element_located((By.CSS_SELECTOR, "body")))


def assert_no_encoding_artifacts(driver: webdriver.Remote, context: str) -> None:
    markup = driver.page_source
    for marker in ["Ã", "Â", "�", "\ufeff"]:
        if marker in markup:
            raise AssertionError(f"{context}: unexpected encoding marker {marker!r}")


def check_language_header(driver: webdriver.Remote, language: str, expected: dict[str, str]) -> None:
    open_path(driver, f"?lang={language}&page=faq")
    context = f"{language} FAQ page"
    assert_equal(driver.find_element(By.TAG_NAME, "html").get_attribute("lang"), expected["html"], context)
    assert_no_encoding_artifacts(driver, context)

    nav_text = driver.find_element(By.CSS_SELECTOR, ".nav-list").text
    assert_text_contains(nav_text, expected["faq"], f"{context} nav FAQ")
    assert_text_contains(nav_text, expected["dossiers"], f"{context} nav dossiers")

    slogan = driver.find_element(By.CSS_SELECTOR, ".brand-slogan").text
    assert_equal(slogan, expected["slogan"], f"{context} brand slogan")

    heading = driver.find_element(By.CSS_SELECTOR, "#faq-title").text
    assert_equal(heading, expected["faq_title"], f"{context} title")

    search = driver.find_element(By.ID, "global-search")
    if not search.get_attribute("placeholder"):
        raise AssertionError(f"{context}: search placeholder is empty")

    first_button = driver.find_element(By.CSS_SELECTOR, ".faq-button")
    answer_id = first_button.get_attribute("aria-controls")
    first_button.click()
    WebDriverWait(driver, 10).until(
        lambda browser: browser.find_element(By.ID, answer_id).is_displayed()
        and first_button.get_attribute("aria-expanded") == "true"
    )


def check_page_matrix(driver: webdriver.Remote, language: str, expected: dict[str, str]) -> None:
    for page in MAIN_PAGES:
        open_path(driver, f"?lang={language}&page={page}")
        context = f"{language} {page}"
        assert_equal(driver.find_element(By.TAG_NAME, "html").get_attribute("lang"), expected["html"], context)
        assert_no_encoding_artifacts(driver, context)
        canonical = driver.find_element(By.CSS_SELECTOR, "link[rel='canonical']").get_attribute("href")
        assert_text_contains(canonical, f"lang={language}", f"{context} canonical")

    for detail_query in DETAIL_PAGES:
        open_path(driver, f"?lang={language}&{detail_query}")
        context = f"{language} detail {detail_query}"
        assert_equal(driver.find_element(By.TAG_NAME, "html").get_attribute("lang"), expected["html"], context)
        assert_no_encoding_artifacts(driver, context)
        body_text = driver.find_element(By.TAG_NAME, "body").text
        if "introuvable" in body_text.lower() or "not found" in body_text.lower():
            raise AssertionError(f"{context}: page unexpectedly rendered as not found")


def main() -> int:
    wait_for_http(f"{APP_HEALTH_URL}/?lang=fr&page=accueil", "MyAgri")
    wait_for_http(SELENIUM_URL.replace("/wd/hub", "/status"), "Selenium")

    options = ChromeOptions()
    options.add_argument("--headless=new")
    options.add_argument("--window-size=1440,1100")
    options.add_argument("--disable-dev-shm-usage")
    options.add_argument("--no-sandbox")

    driver = webdriver.Remote(command_executor=SELENIUM_URL, options=options)
    driver.set_page_load_timeout(25)
    try:
        for language, expected in LANGUAGES.items():
            check_language_header(driver, language, expected)
            check_page_matrix(driver, language, expected)

        driver.set_window_size(390, 844)
        check_language_header(driver, "nl", LANGUAGES["nl"])
    finally:
        driver.quit()

    print("Selenium tests OK")
    return 0


if __name__ == "__main__":
    try:
        raise SystemExit(main())
    except (AssertionError, RuntimeError, WebDriverException) as exc:
        print(f"Selenium tests failed: {exc}", file=sys.stderr)
        raise SystemExit(1)
