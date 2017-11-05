#!/bin/sh

minify assets/chaocovietnam.js --output assets/minified/chaocovietnam.js
minify assets/chaocovietnam.css --output assets/minified/chaocovietnam.css

gcloud app deploy -v v2-20171105
