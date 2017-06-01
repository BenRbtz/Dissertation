// Configuring Text Editor Style
var editor = ace.edit("editor");

editor.setTheme("ace/theme/tomorrow_night_bright"); // set theme
editor.getSession().setUseWrapMode(true); // wrap text if off screen
editor.getSession().setMode("ace/mode/python"); // Set Python Syntax
