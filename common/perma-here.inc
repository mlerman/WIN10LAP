<input type="radio" name="cb" value="ipconfig" onclick="onradioclick(this.value);"  />ipconfig<br/>
<input type="radio" name="cb" value="git init --shared=0777" onclick="onradioclick(this.value);"  />git init --shared=0777 <span style="background-color:lightblue;">create git local repository</span><br/>
<input type="radio" name="cb" value="netsh wlan connect name=muwifi_corp" onclick="onradioclick(this.value);"  />connect <span style="background-color:yellow;">muwifi_corp</span><br/>
<input type="radio" name="cb" value='netsh wlan disconnect interface="Wireless Network Connection 3"' onclick="onradioclick(this.value);"  />disconnect wifi go <span style="background-color:lightgreen;">wired</span><br/>
<!-- input type="radio" name="cb" value='netsh lan connect name="Local Area Connection"' onclick="onradioclick(this.value);"  />connect wired LAN<br/ -->
<input type="radio" name="cb" value='del c:\Users\mlerman\Downloads\ui_*.bat /Q & del c:\Users\mlerman\Downloads\*.run /Q & echo done' onclick="onradioclick(this.value);"  />Clear all ui_*.bat ui_*.run in Downloads<br/>
<input type="radio" name="cb" value='c:\UniServer\www\common\clean_apache_log.bat' onclick="onradioclick(this.value);"  />Clean apache logs<br/>
<input type="radio" name="cb" value='type c:\UniServer\usr\local\apache2\logs\error.log' onclick="onradioclick(this.value);"  />Show apache errors<br/>
