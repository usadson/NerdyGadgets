import urllib.request
import time
import urllib.parse
from sense_hat import SenseHat


while True:
     
    sense = SenseHat()
    sense.clear()
    temp = sense.get_temperature_from_pressure()
    temp = round(temp -20, 1)
    x = temp
    print (x);

    X = (x)
    X = str(X)
    link = ("http://10.80.17.2/NerdyGadgets/pitemp.php?temp=" + X)
    print (link)
    with urllib.request.urlopen(link) as response:
        html = response.read()
    time.sleep (3)