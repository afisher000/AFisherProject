# %%
import requests
from bs4 import BeautifulSoup

alias = 'pietro'

def submit_player(alias, fullname):
    [firstname, lastname] = fullname.split(' ')

    home_webpage = 'http://127.0.0.1:8000'
    # home_webpage = 'https://afisherproject.com'

    # Get csrf token from webpage
    form_url = home_webpage+'/foosball/players/create'
    r = requests.get(form_url)
    soup = BeautifulSoup(r.text, 'html.parser')
    for link in soup.find_all('input'):
        if hasattr(link, 'name') and link['name']=='_token':
            csrf_token = link['value']
    print(csrf_token)

    # Also input cookies so csrf token is unchanged
    jar = requests.cookies.RequestsCookieJar()
    # jar.set('XSRF-TOKEN', r.cookies['XSRF-TOKEN'])
    jar.set('laravel_session', r.cookies['laravel_session'])

    # Submit game to laravel webpage
    post_url = home_webpage+'/foosball/players'
    player_data = {
        '_token': csrf_token,
        'alias': alias,
        'fullname': str.title(firstname) + '_' + str.title(lastname)
    }
    response = requests.post(post_url, data=player_data, cookies=jar)

    # Check the response status
    if response.status_code == 200:
        print("Player added successfully")
    else:
        print(response.reason)

# %%
