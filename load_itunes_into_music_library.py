# %%
import os
from Databases import MasterDatabase
from string import capwords


db = MasterDatabase()


music_folder = 'C:\\Users\\afish\\Music\\iTunes\\iTunes Media\\Music'
artists = os.listdir(music_folder)
for artist in artists:
    # All albums are Main
    artist_path = os.path.join(music_folder, artist, 'Main') 
    songs = os.listdir(artist_path)


    for song in songs:
        artist_name = capwords(artist)
        song_name = capwords(song[:-4])

        # # Removing " 2" appended to some songs
        # if song_name[-1]=='2':
        #     song_name = song_name[:-2]
        #     orig_song_path = os.path.join(artist_path, song)
        #     new_song_path = os.path.join(artist_path, song_name+'.mp4')
        #     os.rename(orig_song_path, new_song_path)

        # Check if entry exists
        if not db.exists('music_library', f'artist="{artist_name}" AND name="{song_name}"'):

            # Insert into database table
            print(f'Inserting {artist_name}/{song_name}')
            query = f'INSERT INTO music_library (artist, name) values ("{artist_name}", "{song_name}")'
            db.execute(query)

        






# %%
