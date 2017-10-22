import sys,os

c = sys.argv[1]

os.system('git add *')
os.system('git commit -m \"' + str(c) + '\"')
os.system('git push origin master')
