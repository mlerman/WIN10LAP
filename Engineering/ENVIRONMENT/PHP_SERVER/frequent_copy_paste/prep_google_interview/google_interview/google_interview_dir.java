package com.srccodes.example;

public class google_interview_dir {
	
	
	
	public static int printSum(String s){
	       String[] arr=s.split("\n");
	       int sum=0, spaces=0;
	       for(int i=arr.length-1;i>=0;i--){
	           String line=arr[i];
	           if(line.contains(".gif") | line.contains(".jpeg") ){
	               spaces=line.length()-line.trim().length();
	           }
	           if(spaces> line.length()-line.trim().length() ){
	               sum+=line.trim().length()+1;
	               spaces--;
	           }
	       }
	       return sum;
	}
	

	/**
	 * @param args
	 */
	public static void main(String[] args) {
		String s = new String("dir1\n dir11\n dir12\n  picture.jpeg\n  dir 121\n   file1.txt\ndir2\n file2.gif\n");
		System.out.println("Sum is " + printSum(s));
	}

}
