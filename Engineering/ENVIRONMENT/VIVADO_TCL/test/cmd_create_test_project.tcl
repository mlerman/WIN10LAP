puts "Running cmd_create_test_project.tcl"

set design project_1
set partname "xcvu3p-ffvc1517-2-e"
set projdir c:/UniServer/www/doc/files/Engineering/ENVIRONMENT/VIVADO/test_project_creation
puts $design
puts $partname
puts $projdir
puts "ca ne marche pas"
#create_project -force $design $projdir -part $partname
after 10