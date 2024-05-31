# %%
import requests
from bs4 import BeautifulSoup


# Get csrf token from webpage
form_url = 'https://afisherproject.com/foosball/games/create'
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
post_url = 'https://afisherproject.com/foosball/games'
game_data = {
    '_token':csrf_token,
    'WO':'andy',
    'WD':'sophie',
    'LO':'max',
    'LD':'pietro',
    'color':'red',
    'score':'8'
}
response = requests.post(post_url, data=game_data, cookies=jar)

# Check the response status
if response.status_code == 200:
    print("Game added successfully")
else:
    print(response.reason)

# %%
