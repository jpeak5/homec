#!/usr/local/bin/python3.7

from pprint import pprint
from bson.objectid import ObjectId
from pymongo import MongoClient
import datetime

client = MongoClient('mongodb://localhost:27017/')
db = client.test_database
collection = db.test_collection
post = {"author": "Mike",
    "text": "My first blog post!",
    "tags": ["mongodb", "python", "pymongo"],
    "date": datetime.datetime.utcnow()}
posts = db.posts
post_id = posts.insert_one(post).inserted_id
pprint(f"post_id: {post_id}")
pprint(f"list_collection_names: {db.list_collection_names()}")
pprint(posts.find_one())
pprint(posts.find_one({"author": "Mike"}))
pprint(posts.find_one({"author": "Eliot"}))
pprint(posts.find_one({"_id": post_id}))


# The web framework gets post_id from the URL and passes it as a string
def get(post_id):
    # Convert from string to ObjectId:
    document = client.db.collection.find_one({'_id': ObjectId(post_id)})
pprint(f"getting post_id '{post_id}' with get(): {get(post_id)}")
