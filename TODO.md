# Server/API
- [ ] Calc distance (phpGEO) between all online sensors and a specific signal, in order to find the primary and secondary sensor.

# Client
- [ ] Backend proxy (`backend.php`) locally on clients that does guzzle/curl to the server (so we don't have to bother with CORS in the frontend)

## SENSOR
- [ ]

# Admin
- [ ] Create new signal emitters (instances of `emitter_types`, ie machines placeable on map.
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
