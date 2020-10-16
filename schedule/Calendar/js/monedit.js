/*
 * Another In Place Editor - a jQuery edit in place plugin
 *
 * Copyright (c) 2009 Dave Hauenstein
 *
 * License:
 * This source file is subject to the BSD license bundled with this package.
 * Available online: {@link http://www.opensource.org/licenses/bsd-license.php}
 * If you did not receive a copy of the license, and are unable to obtain it,
 * email davehauenstein@gmail.com,
 * and I will send you a copy.
 *
 * Project home:
 * http://code.google.com/p/jquery-in-place-editor/
 *
 */
$(document).ready(function(){

    // This example only specifies a URL to handle the POST request to
    // the server, and tells the script to show the save / cancel buttons
    $(".editme1").editInPlace({
        url: "./server.php",
        show_buttons: true,
	saving_image: "images/ajax-loader.gif"
    });

    // This example shows how to call the function and display a textarea
    // instead of a regular text box. A few other options are set as well,
    // including an image saving icon, rows and columns for the textarea,
    // and a different rollover color.
    $(".editme2").editInPlace({
        url: "./server.php",
        bg_over: "#cff",
        field_type: "textarea",
        textarea_rows: "15",
        textarea_cols: "35",
	 show_buttons: true,
        saving_image: "images/ajax-loader.gif"
    });

    // A select input field so we can limit our options
    $(".editme3").editInPlace({
        url: "./server.php",
        field_type: "select",
	 show_buttons: true,
        select_options: "Male, Female"
    });
	
	

    // Using a callback function to update 2 divs
    $(".editme4").editInPlace({
        url: "./server.php",
        callback: function(original_element, html, original){
            $("#updateDiv1").html("The original html was: " + original);
            $("#updateDiv2").html("The updated text is: " + html);
            return(html);
        }
    });
	//bday month select
	 $(".editme5").editInPlace({
        url: "./server.php",
        field_type: "select",
	 show_buttons: true,
        select_options: "January, Febuary, March, April, May, June, July, August, September, October, November, December"
    });

	//bday day select
	 $(".editme6").editInPlace({
        url: "./server.php",
        field_type: "select",
	 show_buttons: true,
        select_options: "1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31"
    });

	//bday year select
	 $(".editme7").editInPlace({
        url: "./server.php",
        field_type: "select",
	 show_buttons: true,
        select_options: "2008, 2007, 2006, 2005, 2004, 2003, 2002, 2001, 2000, 1999, 1998,1997,1996,1995,1994,1993,1992,1991,1990,1989,1988,1987,1986,1985,1984,1983,1982,1981,1980,1979,1978,1977, 1976, 1975, 1974, 1973, 1972, 1971, 1970, 1969, 1968, 1967, 1966, 1965, 1964, 1963, 1962, 1961, 1960"
    });
});