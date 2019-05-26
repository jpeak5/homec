#!/usr/local/bin/python3.7

from pprint import pprint
from bson.objectid import ObjectId
from pymongo import MongoClient
import datetime

client = MongoClient('mongodb://localhost:27017/')
db = client.test_database
posts = db.posts

new_posts = [{"author": "Mike",
  "text": "Another post!",
  "tags": ["bulk", "insert"],
  "date": datetime.datetime(2009, 11, 12, 11, 14)},
  {"author": "Eliot",
  "title": "MongoDB is fun",
  "text": "and pretty easy too!",
  "date": datetime.datetime(2009, 11, 10, 10, 45)}]

result = posts.insert_many(new_posts)
pprint(result.inserted_ids)
