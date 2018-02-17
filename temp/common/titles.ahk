WinGet, windows, list

DebugMessage(str)
{
 global h_stdout
 DebugConsoleInitialize()  ; start console window if not yet started
 str .= "`n" ; add line feed
 DllCall("WriteFile", "uint", h_Stdout, "uint", &str, "uint", StrLen(str), "uint*", BytesWritten, "uint", NULL) ; write into the console
 WinSet, Bottom,, ahk_id %h_stout%  ; keep console on bottom
}

DebugConsoleInitialize()
{
   global h_Stdout	 ; Handle for console
   static is_open = 0  ; toogle whether opened before
   if (is_open = 1)	 ; yes, so don't open again
	 return
	 
   is_open := 1
   ; two calls to open, no error check (it's debug, so you know what you are doing)
   DllCall("AttachConsole", int, -1, int)
   DllCall("AllocConsole", int)
   dllcall("SetConsoleTitle", "str","Paddy Debug Console")	; Set the name. Example. Probably could use a_scriptname here
   h_Stdout := DllCall("GetStdHandle", "int", -11) ; get the handle
   WinSet, Bottom,, ahk_id %h_stout%	  ; make sure it's on the bottom
   WinActivate,Lightroom   ; Application specific; I need to make sure this application is running in the foreground. YMMV
   return
} 

Loop, %windows%
{
    id := windows%A_Index%
    WinGet, process, ProcessName, ahk_id %id%
    WinGetTitle, title, ahk_id %id%
    FileAppend, %process% %title%`n, *
    ;DebugMessage(title) 
    if title = MiniMenu 
    {
      DebugMessage("Found MiniMenu")
      WinSet, AlwaysOnTop, Off, ahk_id %id%
      Sleep, 100
      WinSet, AlwaysOnTop, On, ahk_id %id%
      Sleep, 100
      WinSet, AlwaysOnTop, Off, ahk_id %id%
      Sleep, 100
      WinSet, AlwaysOnTop, On, ahk_id %id%
      Sleep, 100
    }
}
ExitApp