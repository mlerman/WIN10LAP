;Double Right Click to paste
~RButton::
If (A_PriorHotKey = A_ThisHotKey and A_TimeSincePriorHotkey < 500)
{
Sleep 200 ; wait for right-click menu, fine tune for your PC
Send {Esc} ; close it
Send ^v ; or your double-right-click action here
}
Return