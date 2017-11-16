# ceci appelle le program
C:\"Program Files (x86)"\Google\Chrome\Application\chrome.exe --new-window --app="data:text/html,<html><body><script>window.moveTo(50,50);window.resizeTo(16,16);window.location='http://win7-pc/doc/files/Engineering/ENVIRONMENT/PHP_SERVER/mini_menu_always_on_top/';</script></body></html>"
$name = "chrome"

# ceci appelle le program
#$exe = c:\Windows\notepad.exe
#$name = "notepad"

function Set-TopMost($handle) {
  $FnDef = '
  [DllImport("user32.dll")]
  public static extern bool SetWindowPos(int hWnd, int hAfter, int x, int y, int cx, int cy, uint Flags);
  ';
  $user32 = Add-Type -MemberDefinition $FnDef -Name 'User32' -Namespace 'Win32' -PassThru
  $user32::SetWindowPos($handle, -1, 0,0,0,0, 3)
}

#$pname = [System.IO.Path]::GetFileNameWithoutExtension($exe)

$p = (Get-Process "$name" -ErrorAction "SilentlyContinue") | ? { $_.MainWindowHandle -ne 0 }
if ($p -eq $null) {
  while ($p -eq $null) {
    sleep -Milliseconds 100
    $p = (Get-Process "$name" -ErrorAction "SilentlyContinue") | ? { $_.MainWindowHandle -ne 0 }
  }
}

$p.MainWindowHandle
#Set-TopMost $p.MainWindowHandle

