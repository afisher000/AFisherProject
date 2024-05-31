# -*- coding: utf-8 -*-
"""
Created on Mon Sep 19 17:51:26 2022

@author: afish
"""
# %%

import sys
from APIs import StravaAPI

# Check for command line arguments
if len(sys.argv) < 1:
    raise Exception('Usage: python update_strava.py <keyword> <value>')
else:
    access_token = sys.argv[1]
    
# Update activities and streams by querying Strava API
api = StravaAPI(access_token=access_token)
api.download_activities()
api.download_streams()


# %%
