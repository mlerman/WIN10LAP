echo This computer: %computername%
rem disconnect the wireless
netsh interface set interface "Wireless Network Connection" admin=disable 

netsh interface ipv4 show config name="Local Area Connection"
netsh interface ipv4 set address name="Local Area Connection" static 192.168.1.30 255.255.255.0 
rem netsh interface ipv4 set dnsserver name="Local Area Connection" static 0.0.0.0 primary
rem netsh interface ipv4 add dnsservers name="Local Area Connection" address="0.0.0.0" validate=yes index=2

echo current dir = %cd%

@echo MSGBOX "Wired connection at Micron is configured for static IP 192.168.1.30 Limited to local switch connections " > TEMPmessage.vbs
@call TEMPmessage.vbs
@del TEMPmessage.vbs /f /q
