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
        url: "editimageserver.php",
        show_buttons: true,
	saving_image: "images/ajax-loader.gif"
    });

	 $(".editme12").editInPlace({
        url: "editimageserver.php",
        show_buttons: true,
	saving_image: "images/ajax-loader.gif"
    });
    // This example shows how to call the function and display a textarea
    // instead of a regular text box. A few other options are set as well,
    // including an image saving icon, rows and columns for the textarea,
    // and a different rollover color.
    $(".editme2").editInPlace({
        url: "editimageserver.php",
        bg_over: "#cff",
        field_type: "textarea",
        textarea_rows: "15",
        textarea_cols: "35",
	 show_buttons: true,
        saving_image: "images/ajax-loader.gif"
    });

	

  
	//bday month select
	 $(".editme5").editInPlace({
        url: "editimageserver.php",
        field_type: "select",
	 show_buttons: true,
        select_options: "Anime / Manga, Book, Comic, Game, J-Pop/J-Rock, Movie, Original Cosplay, TV Series"
    });

	
});