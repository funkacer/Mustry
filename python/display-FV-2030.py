import serial
import time
import json
import sys

if(len(sys.argv)<2):
        print("display.py port 'prvni radek' 'druhy radek'")
        sys.exit()

# nastaveni seriove komunikace
con = serial.Serial(port=sys.argv[1],
                        baudrate=9600,
                        bytesize=serial.EIGHTBITS,
                        parity=serial.PARITY_NONE,
                        stopbits=serial.STOPBITS_ONE,
                        timeout=None,
                        xonxoff=False,
                        rtscts=False,
                        writeTimeout=None,
                        dsrdtr=False,
                        interCharTimeout=None)


# zapis hodnotu
ustring = sys.argv[3].rjust(20)+sys.argv[2].ljust(20)+'\r\r'
con.write(ustring.encode())
con.close()