# Lotka-Volterra API

# Signal data
## List all signals
<details>
 <summary><code>GET</code> <code><b>/signals</b></code> <code>(list all active signals)</code></summary>

### Parameters

> None

### Example return data
```json
[
  {
    "id": 329,
    "interceptTime": "2032-02-14 05:23:11",
    "sensorData": {
      "primary": {
        "bearing": 178,
        "dopplershift": 2.1,
        "drift": 4,
        "id": 3,
        "name": "BRAVO"
      },
      "secondary": {
        "bearing": 32,
        "dopplershift": 3.2,
        "drift": 2,
        "id": 4,
        "name": "CHARLIE"
      }
    },
    "signalData": {
      "cipherMessage": ");_^9:zPO&1%_==^`>G§2),ODNM)#_K",
      "cleartextMessage": "ANOMALY DETECTED REDIRECTING TO INVESTIGATE",
      "emitterType": "XM32 PUPPEMASTER",
      "emitterTypeId": 18,
      "machineId": 3921,
      "signalSoundFile": "xm32_009.wav",
      "signalSpectrogramFile": "xm32_009.png"
    }
  },
  {
    "id": 330,
    "interceptTime": "2032-02-14 05:42:09",
    "sensorData": {
      "primary": {
        "bearing": 322,
        "dopplershift": 1,
        "drift": 0,
        "id": 2,
        "name": "ALPHA"
      },
      "secondary": {
        "bearing": 201,
        "dopplershift": 0,
        "drift": 0,
        "id": 4,
        "name": "CHARLIE"
      }
    },
    "signalData": {
      "cipherMessage": "K#)(H=!Ä;ä$1ä$@£:kSÖQ0¤;=I;F9)",
      "cleartextMessage": "MOVING TO ?, UNLOADING RESOURCES",
      "emitterType": "XM19 THESEUS",
      "emitterTypeId": 11,
      "machineId": 3921,
      "signalSoundFile": "xm19_002.wav",
      "signalSpectrogramFile": "xm19_002.png"
    }
  }
]
```


### Example cURL

> ```javascript
>  curl -X GET -H "Content-Type: application/json" --data @post.json http://localhost:80/api/signals
> ```

</details>

------------------------------------------------------------------------------------------

## Get a signal by ID
<details>
 <summary><code>GET</code> <code><b>/signals/{id}</b></code> <code>(Get a signal by its ID)</code></summary>

### Parameters

> | name      |  type     | data type               | description                                                           |
> |-----------|-----------|-------------------------|-----------------------------------------------------------------------|
> | id        |  required | integer                 | |


### Example return data
```json
[
  {
    "id": 329,
    "interceptTime": "2032-02-14 05:23:11",
    "designation": "",
    "status": {
        "sensors": [
            "noticed": true, // Did the SENSOR workstation at least click to open this signal data?
            "designated": true // Did the SENSOR workstation assign a designation to this signal?
        ],
        "sigint": [
            "noticed": true, // Did SIGINT open this signal?
            "identified": true, // Did SIGINT assign an emitter type to this signal?            
            "correctlyIdentified": false // Did SIGINT correctly identify the signal emitter type?
            "cheated": false // Did SIGINT press the "cheat" button?
        ],
        "geo": [
            "plotted": true // Did GEO enter coordinates back into the system for this signal?
        ],
        "analysis": [
            "noticed": true, // Did the ANALYSIS at least click to open this signal data?
            "deciphered": false, // Did ANALYSIS decipher the message?
            "cheated": false // Did ANALYSIS press the "cheat" button?
        ]
    },
    "sensorData": {
      "primary": {
        "bearing": 178,
        "dopplershift": 2.1, // used to calculate object velocity
        "drift": 4, // used to calculate cone of possible heading of object
        "id": 3,
        "name": "BRAVO"
      },
      "secondary": {
        "bearing": 32,
        "dopplershift": 3.2,
        "drift": 2,
        "id": 4,
        "name": "CHARLIE"
      }
    },
    "signalData": {
      "frequency": 982.13,
      "cipherMessage": ");_^9:zPO&1%_==^`>G§2),ODNM)#_K",
      "cleartextMessage": "ANOMALY DETECTED REDIRECTING TO INVESTIGATE",
      "emitterType": "XM32 PUPPEMASTER",
      "emitterTypeId": 18,
      "machineId": 3921,
      "signalSoundFile": "xm32_009.wav",
      "signalSpectrogramFile": "xm32_009.png"
    }
  }
]
```


### Example cURL

> ```javascript
>  curl -X GET -H "Content-Type: application/json" --data @post.json http://localhost:80/api/signals/1
> ```

</details>

------------------------------------------------------------------------------------------
