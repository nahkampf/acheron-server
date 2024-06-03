# Server/API
- [x] Calc distance (phpGEO) between all online sensors and a specific signal, in order to find the primary and secondary sensor.
  - [ ] Don't recalc when a sensor goes offline
- [x] Automatically assign primary and secondary sensor to signal
- [x] Assign bearings from sensors to signal (and reverse)

## SENSOR/signals
- [X] /signals to expose all (current) signals as JSON (for client calls)
- [ ] Some endpoint to update signal data ("handled", sensor work complete, sigint complete, decrypt complete etc)
- [ ] Call to update intercept timestamp on a signal

## SIGINT
- [X] Phrases and message editor 
- [ ] Create a "payload" consisting of random chars and the "encrypted" message
- [ ] Drill-down "recognition manual" interface to identify signals (number of carrier waves, frequencies, positions of data blocks etc)

## GEO
todo

## SCIENCE
- [ ] "Archive" of XM types etc
  - [X] Emitters table
  - [ ] Generate ML images of all XM types
  - [ ] 

## ARCHIVE
todo

## COMMAND
todo

# Admin
- [X] Create new signal emitters (instances of `emitter_types`, ie machines placeable on map.
- [ ] Interface to create new signal
  - [ ] Position (from google maps, WGS84)
  - [X] Primary Sensor & Secondary sensor (calced)
  - [X] Heading
  - [X] Velocity
  - [X] Assign a spectrogram & wave file based on emitter type
  - [ ] Assign a premade signal data message
- [ ] Signal data message creator/editor
  - [X] Define corpus of terms/words & editor

# Misc
- [X] Team monitor (display name, portrait, biomonitor status) + audible alerts
- [ ] 
- [ ] 

