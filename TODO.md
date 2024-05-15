# Server/API
- [x] Calc distance (phpGEO) between all online sensors and a specific signal, in order to find the primary and secondary sensor.
- [x] Automatically assign primary and secondary sensor to signal
- [x] Assign bearings from sensors to signal (and reverse)

# Client
- [X] Backend proxy (`backend.php`) locally on clients that does guzzle/curl to the server (so we don't have to bother with CORS in the frontend)
- [ ] Code Blue/Code Red overrides (full screen modals triggered by `backend.php` (also reset to normal)

## SENSOR
- [ ]

## SIGINT

## GEO

## SCIENCE

## ARCHIVE

## COMMAND

# Admin
- [X] Create new signal emitters (instances of `emitter_types`, ie machines placeable on map.
- [ ] Interface to create new signal
  - [ ] Position (from google maps, WGS84)
  - [ ] Primary Sensor & Secondary sensor (calced)
  - [ ] Heading
  - [ ] Velocity
  - [ ] Assign a spectrogram & wave file based on emitter type
  - [ ] Assign a premade signal data message
- [ ] Signal data message creator/editor
  - [ ] Define corpus of terms/words

# Misc
