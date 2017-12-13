proc dec2bin x {
    if {[string index $x 0] eq {-}} {
        set sign -
        set x [string range $x 1 end]
    } else {
        set sign {}
    }
    return $sign[string trimleft [string map {
    0 {000} 1 {001} 2 {010} 3 {011} 4 {100} 5 {101} 6 {110} 7 {111}
    } [format %o $x]] 0]
}

proc dec2binw {i {width {}}} {
    #returns the binary representation of $i
    # width determines the length of the returned string (left truncated or added left 0)
    # use of width allows concatenation of bits sub-fields

    set res {}
    if {$i<0} {
        set sign -
        set i [expr {abs($i)}]
    } else {
        set sign {}
    }
    while {$i>0} {
        set res [expr {$i%2}]$res
        set i [expr {$i/2}]
    }
    if {$res eq {}} {set res 0}

    if {$width ne {}} {
        append d [string repeat 0 $width] $res
        set res [string range $d [string length $res] end]
    }
    return $sign$res
}

set varh [format %08X $var]
puts "hex : $varh"
set str "bin : "
append str [dec2binw $var 32]
puts $str;
puts "      ^  ^   ^   ^   ^   ^   ^   ^   ^"
puts "      3  2   2   2   1   1   8   4   0"
puts "      1  8   4   0   6   2"

