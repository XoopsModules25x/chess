//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
//  Author: Dave Lerner ( http://Dave-L.com ) 2003-01-28                     //
// ------------------------------------------------------------------------- //
//  History:
//    1.0.0 - Original release #*#UNCACHE_DATES#
// ------------------------------------------------------------------------- //

// Emulate PHP function: string date ( string format [, int timestamp ] )
//
// format    - format string
// timestamp - seconds since 1970-01-01 00:00:00 GMT
//
// The following format codes recognized by the PHP function are not supported here: I T
// Unsupported format codes are passed through as-is, but are highlighted with HTML tags.
//
// Example:
//   document.write(phpDate('Y/n/j G:i', 1072318699))) // prints '2003/12/25 2:18' (GMT)

function phpDate(format)
{
	var format_string = new String(format);

	// The timestamp parameter is optional; its absence is interpreted as "now".
	var date = (arguments.length >= 2) ? new Date(arguments[1] * 1000) : new Date();

	var pre = '<u><b><i>';    // prefix for highlighting unsupported code
	var suf = '</i></b></u>'; // suffix for highlighting unsupported code
	var rtn = '';             // return value
	var x, y;                 // temporaries

	for (var i = 0; i < format_string.length; ++i) {

		var format_char = format_string.charAt(i);

		switch (format_char) {

			default: // Pass through unrecognized characters in the format string as-is.
				rtn += format_char;
				break;

			case '\\': // Pass through following character as-is.
				++i;
				rtn += format_string.charAt(i);
				break;

			case 'a':
				x = date.getHours();
				rtn += x >= 12 ? 'pm' : 'am'; 
				break;

			case 'A':
				x = date.getHours();
				rtn += x >= 12 ? 'PM' : 'AM'; 
				break;

			case 'B':
				x = Math.floor(((((date.getUTCHours() + 1) % 24) * 60 + date.getUTCMinutes()) * 60 + date.getUTCSeconds()) / 86.4);
				rtn += x < 10 ? '00' + x : (x < 100 ? '0' + x : x);
				break;

			case 'd':
				x = date.getDate();
				rtn += x < 10 ? '0' + x : x;
				break;

			case 'D':
				x = date.getDay();
				y = new Array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
				rtn += y[x];
				break;

			case 'F':
				x = date.getMonth();
				y = new Array('January','February','March','April','May','June','July','August','September','October','November','December');
				rtn += y[x];
				break;

			case 'g':
				x = date.getHours();
				rtn += x > 12 ? x - 12 : x;
				break;

			case 'G':
				rtn += date.getHours();
				break;

			case 'h':
				x = date.getHours();
				y = x > 12 ? x - 12 : x;
				rtn += y < 10 ? '0' + y : y;
				break;

			case 'H':
				x = date.getHours();
				rtn += x < 10 ? '0' + x : x;
				break;

			case 'i':
				x = date.getMinutes();
				rtn += x < 10 ? '0' + x : x;
				break;

			case 'I': // unsupported
				rtn += pre + format_char + suf;
				break;

			case 'j':
				rtn += date.getDate();
				break;

			case 'l':
				x = date.getDay();
				y = new Array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
				rtn += y[x];
				break;

			case 'L':
				x = date.getFullYear();
				rtn += (x % 400 == 0) || ((x % 4 == 0) && (x % 100 != 0)) ? 1 : 0;
				break;

			case 'm':
				x = date.getMonth() + 1;
				rtn += x < 10 ? '0' + x : x;
				break;

			case 'M':
				x = date.getMonth();
				y = new Array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
				rtn += y[x];
				break;

			case 'n':
				rtn += date.getMonth() + 1;
				break;

			case 'O':
				var sign, hours, minutes;
				x = date.getTimezoneOffset();
				y = Math.abs(x);
				sign = x <= 0 ? '+' : '-'; // sign is reversed for consistency with PHP
				hours = Math.floor(y / 60);
				hours = new String(hours < 10 ? '0' + hours : hours);
				minutes = y % 60;
				minutes = new String(minutes < 10 ? '0' + minutes : minutes);
				rtn += sign + hours + minutes;
				break;

			case 'r':
				rtn += phpDate('D, j M Y H:i:s O', Math.floor(date.getTime() / 1000)); // recursive call
				break;

			case 's':
				x = date.getSeconds();
				rtn += x < 10 ? '0' + x : x;
				break;

			case 'S':
				x = date.getDate();
				y = new Array(
					'st','nd','rd','th','th','th','th','th','th','th',
					'th','th','th','th','th','th','th','th','th','th',
					'st','nd','rd','th','th','th','th','th','th','th',
					'st'
				);
				rtn += y[x - 1];
				break;

			case 't':
				x = date.getFullYear();
				y = new Array(31,0,31,30,31,30,31,31,30,31,30,31);
				y[1] = (x % 400 == 0) || ((x % 4 == 0) && (x % 100 != 0)) ? 29 : 28;
				rtn += y[date.getMonth()];
				break;

			case 'T': // unsupported
				rtn += pre + format_char + suf;
				break;

			case 'U':
				rtn += Math.floor(date.getTime() / 1000);
				break;

			case 'w':
				rtn += date.getDay();
				break;

			case 'W':
				x = new Date(date.getFullYear(), 0, 1); // date at beginning of current year
				rtn += Math.floor((date - x) / (7 * 24 * 60 * 60 * 1000)) + 1;
				break;

			case 'Y':
				rtn += date.getFullYear();
				break;

			case 'y':
				x = new String(date.getFullYear());
				rtn += x.substr(2, 2); 
				break;

			case 'z':
				x = new Date(date.getFullYear(), 0, 1); // date at beginning of current year
				rtn += Math.floor((date - x) / (24 * 60 * 60 * 1000));
				break;

			case 'Z':
				rtn += -date.getTimezoneOffset() * 60;
				break;
		}
	}

	return rtn;
}
