<?php
/** !
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* [filename] is a part of PeopleAggregator.
* [description including history]
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* @author [creator, or "Original Author"]
* @license http://bit.ly/aVWqRV PayAsYouGo License
* @copyright Copyright (c) 2010 Broadband Mechanics
* @package PeopleAggregator
*/
?>
<?php

class parseCSV {
	
/*

	Class: parseCSV v0.2.0 beta
	http://zhuoqe.org/svn/codeyard/trunk/php/classes/parseCSV/
	
	Created by Jim Myhrberg (jim@zhuoqe.org).
	
	Fully conforms to the specifications lined out on wikipedia:
	 - http://en.wikipedia.org/wiki/Comma-separated_values
	
	Based on the concept of this class:
	 - http://minghong.blogspot.com/2006/07/csv-parser-for-php.html
	
	
	Code Examples
	----------------
	# general usage
	$csv = new parseCSV('data.csv');
	print_r($csv->data);
	----------------
	# tab delimited, and encoding conversion
	$csv = new parseCSV();
	$csv->encoding('UTF-16', 'UTF-8');
	$csv->delimiter = "\t";
	$csv->parse('data.tsv');
	print_r($csv->data);
	----------------
	# auto-detect delimiter character
	$csv = new parseCSV();
	$csv->auto('data.csv');
	print_r($csv->data);
	----------------
	# modify data in a csv file
	$csv = new parseCSV();
	$csv->sort_by = 'id';
	$csv->parse('data.csv');
	# "4" is the value of the "id" column of the CSV row
	$csv->data[4] = array('firstname' => 'John', 'lastname' => 'Doe', 'email' => 'john@doe.com');
	$csv->save();
	----------------
	# add row/entry to end of CSV file
	#  - only recommended when you know the extact sctructure of the file
	$csv = new parseCSV();
	$csv->save('data.csv', array('1986', 'Home', 'Nowhere', ''), true);
	----------------
	# convert 2D array to csv data and send headers
	# to browser to treat output as a file and download it
	$csv = new parseCSV();
	$csv->output (true, 'movies.csv', $array);
	----------------
	
	
	
	----------
	This program is free software; you can redistributeit and/or modify it
	under the terms of the GNU General Public License as published by the Free
	Software Foundation; either version 2 of the License, or (at your option)
	any later version. http://www.gnu.org/licenses/gpl.txt

	This program is distributed in the hope that it will be useful, but WITHOUT
	ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
	FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for
	more details.

	You should have received a copy of the GNU General Public License along
	with this program; if not, write to the Free Software Foundation, Inc., 59
	Temple Place, Suite 330, Boston, MA 02111-1307 USA
	----------

*/


	/**
	 * Configuration
	 */
	
	# use first line/entry as field names
	var $heading = true;
	
	# override field names
	var $fields = array();
	
	# sort entries by this field
	var $sort_by = null;
	var $sort_reverse = false;
	
	# delimiter (comma) and enclosure (double quote)
	var $delimiter = ',';
	var $enclosure = '"';
	
	# number of rows to analyze when attempting to auto-detect delimiter
	var $auto_depth = 15;
	
	# characters to ignore when attempting to auto-detect delimiter
	var $auto_non_chars = "a-zA-Z0-9\n\r";
	
	# prefered delimiter characters, only used when all filtering method
	# returns multiple possible delimiters (happens very rarely)
	var $auto_prefered = ",;\t.:|";
	
	# character encoding options
	var $convert_encoding = false;
	var $input_encoding = 'ISO-8859-1';
	var $output_encoding = 'ISO-8859-1';
	
	# used by unparse(), save(), and output() functions
	var $linefeed = "\n";
	
	# only used by output() function
	var $output_delimiter = ',';
	var $output_filename = 'data.csv';
	
	
	/**
	 * Internal variables
	 */
	
	# current file
	var $file;
	
	# loaded file contents
	var $file_data;
	
	# array of field values in data parsed
	var $titles = array();
	
	# two dimentional array of CSV data
	var $data = array();
	
	
	/**
	 * Constructor
	 * @param   input   CSV file or string
	 * @return  nothing
	 */
	function parseCSV ($input = null) {
		if ( !empty($input) ) $this->parse($input);
	}
	
	
	// ==============================================
	// ----- [ Main Functions ] ---------------------
	// ==============================================
	
	/**
	 * Parse CSV file or string
	 * @param   input   CSV file or string
	 * @return  nothing
	 */
	function parse ($input = null) {
		if ( !empty($input) ) {
			if ( is_readable($input) ) {
				$this->data = $this->parse_file($input);
			} else {
				$this->file_data = &$input;
				$this->data = $this->parse_string();
			}
			if ( $this->data === false ) return false;
		}
		return true;
	}
	
	/**
	 * Save changes, or new file and/or data
	 * @param   file     file to save to
	 * @param   data     2D array with data
	 * @param   append   append current data to end of target CSV if exists
	 * @param   fields   field names
	 * @return  true or false
	 */
	function save ($file = null, $data = array(), $append = false, $fields = array()) {
		if ( empty($file) ) $file = &$this->file;
		$mode = ( $append ) ? 'at' : 'wt' ;
		$is_php = ( preg_match('/\.php$/i', $file) ) ? true : false ;
		return $this->wfile($file, $this->unparse($data, $fields, $append, $is_php), $mode);
	}
	
	/**
	 * Generate CSV based string for output
	 * @param   output      if true, prints headers and strings to browser
	 * @param   filename    filename sent to browser in headers if output is true
	 * @param   data        2D array with data
	 * @param   fields      field names
	 * @param   delimiter   delimiter used to seperate data
	 * @return  CSV data using delimiter of choice, or default
	 */
	function output ($output = true, $filename = null, $data = array(), $fields = array(), $delimiter = null) {
		if ( empty($filename) ) $filename = $this->output_filename;
		if ( $delimiter === null ) $delimiter = $this->output_delimiter;
		$data = $this->unparse($data, $fields, null, null, $delimiter);
		if ( $output ) {
			header('Content-type: application/csv');
			header('Content-Disposition: inline; filename="'.$filename.'"');
			echo $data;
		}
		return $data;
	}
	
	/**
	 * Convert character encoding
	 * @param   input    input character encoding, uses default if left blank
	 * @param   output   output character encoding, uses default if left blank
	 * @return  nothing
	 */
	function encoding ($input = null, $output = null) {
		$this->convert_encoding = true;
		if ( $input !== null ) $this->input_encoding = $input;
		if ( $output !== null ) $this->output_encoding = $output;
	}
	
	/**
	 * Auto-Detect Delimiter: Find delimiter by analyzing a specific number of
	 * rows to determin most probable delimiter character
	 * @param   file           local CSV file
	 * @param   parse          true/false parse file directly
	 * @param   search_depth   number of rows to analyze
	 * @param   prefered       prefered delimiter characters
	 * @param   enclosure      enclosure character, default is double quote (").
	 * @return  delimiter character
	 */
	function auto ($file = null, $parse = true, $search_depth = null, $prefered = null, $enclosure = null) {
		
		if ( $file === null ) $file = $this->file;
		if ( empty($search_depth) ) $search_depth = $this->auto_depth;
		if ( $enclosure === null ) $enclosure = $this->enclosure;
		
		if ( $prefered === null ) $prefered = $this->auto_prefered;
		
		if ( empty($data) ) {
			if ( $this->check_data() ) {
				$data = &$this->file_data;
			} else return false;
		}
		
		$chars = array();
		$strlen = strlen($data);
		$enclosed = false;
		$n = 1;
		$to_end = true;
		
		// walk specific depth finding posssible delimiter characters
		for ( $i=0; $i < $strlen; $i++ ) {
			$ch = $data[$i];
			$nch = ( isset($data[$i+1]) ) ? $data[$i+1] : false ;
			$pch = ( isset($data[$i-1]) ) ? $data[$i-1] : false ;
			
			// open and closing quotes
			if ( $ch == $enclosure && (!$enclosed || $nch != $enclosure) ) {
				$enclosed = ( $enclosed ) ? false : true ;
			
			// inline quotes	
			} elseif ( $ch == $enclosure && $enclosed ) {
				$i++;

			// end of row
			} elseif ( ($ch == "\n" && $pch != "\r" || $ch == "\r") && !$enclosed ) {
				if ( $n >= $search_depth ) {
					$strlen = 0;
					$to_end = false;
				} else {
					$n++;
				}
				
			// count character
			} elseif (!$enclosed) {
				if ( !preg_match('/['.preg_quote($this->auto_non_chars, '/').']/i', $ch) ) {
					if ( !isset($chars[$ch][$n]) ) {
						$chars[$ch][$n] = 1;
					} else {
						$chars[$ch][$n]++;
					}
				}
			}
		}
		
		// filtering
		$depth = ( $to_end ) ? $n-1 : $n ;
		$filtered = array();
		foreach( $chars as $char => $value ) {
			if ( $match = $this->check_count($char, $value, $depth, $prefered) ) {
				$filtered[$match] = $char;
			}
		}
		
		// capture most probable delimiter
		ksort($filtered);
		$delimiter = reset($filtered);
		$this->delimiter = $delimiter;
		
		// parse data
		if ( $parse ) $this->data = $this->parse_string();
		
		return $delimiter;
		
	}
	
	
	// ==============================================
	// ----- [ Core Functions ] ---------------------
	// ==============================================
	
	/**
	 * Load local file or string
	 * @param   input   local CSV file
	 * @return  true or false
	 */
	function load_data ($input = null) {
		$data = null;
		$file = null;
		if ( $input === null ) {
			$file = $this->file;
		} elseif ( file_exists($input) ) {
			$file = $input;
		} else {
			$data = $input;
		}
		if ( !empty($data) || $data = $this->rfile($file) ) {
			if ( $this->file != $file ) $this->file = $file;
			if ( preg_match('/\.php$/i', $file) && preg_match('/<\?.*?\?>(.*)/ims', $data, $strip) ) {
				$data = ltrim($strip[1]);
			}
			if ( $this->convert_encoding ) $data = iconv($this->input_encoding, $this->output_encoding, $data);
			if ( $data[strlen($data)-1] != "\n" ) $data .= "\n";
			$this->file_data = &$data;
			return true;
		}
		return false;
	}
	
	/**
	 * Read file to string and call parse_string()
	 * @param   file   local CSV file
	 * @return  2D array with CSV data, or false on failure
	 */
	function parse_file ($file = null) {
		if ( $file === null ) $file = $this->file;
		if ( empty($this->file_data) ) $this->load_data($file);
		return ( !empty($this->file_data) ) ? $this->parse_string() : false ;
	}
	
	/**
	 * Parse CSV strings to arrays
	 * @param   data   CSV string
	 * @return  2D array with CSV data, or false on failure
	 */
	function parse_string ($data = null) {
		if ( empty($data) ) {
			if ( $this->check_data() ) {
				$data = &$this->file_data;
			} else return false;
		}
		
		$rows = array();
		$row = array();
		$row_count = 0;
		$current = '';
		$head = ( !empty($this->fields) ) ? $this->fields : array() ;
		$col = 0;
		$enclosed = false;
		$strlen = strlen($data);
		
		// walk through each character
		for ( $i=0; $i < $strlen; $i++ ) {
			$ch = $data[$i];
			$nch = ( isset($data[$i+1]) ) ? $data[$i+1] : false ;
			$pch = ( isset($data[$i-1]) ) ? $data[$i-1] : false ;
			
			// open and closing quotes
			if ( $ch == $this->enclosure && (!$enclosed || $nch != $this->enclosure) ) {
				$enclosed = ( $enclosed ) ? false : true ;
			
			// inline quotes	
			} elseif ( $ch == $this->enclosure && $enclosed ) {
				$current .= $ch;
				$i++;

			// end of field/row
			} elseif ( ($ch == $this->delimiter || ($ch == "\n" && $pch != "\r") || $ch == "\r") && !$enclosed ) {
				$current = trim($current);
				$key = ( !empty($head[$col]) ) ? $head[$col] : $col ;
				$row[$key] = $current;
				$current = '';
				$col++;
			
				// end of row
				if ( $ch == "\n" || $ch == "\r" ) {
					if ( $this->heading && empty($head) ) {
						$head = $row;
					} elseif ( empty($this->fields) || (!empty($this->fields) && (($this->heading && $row_count > 0) || !$this->heading)) ) {
						if ( !empty($this->sort_by) && !empty($row[$this->sort_by]) ) {
							if ( isset($rows[$row[$this->sort_by]]) ) {
								$rows[$row[$this->sort_by].'_0'] = &$rows[$row[$this->sort_by]];
								unset($rows[$row[$this->sort_by]]);
								for ( $sn=1; isset($rows[$row[$this->sort_by].'_'.$sn]); $sn++ ) {}
								$rows[$row[$this->sort_by].'_'.$sn] = $row;
							} else $rows[$row[$this->sort_by]] = $row;
						} else $rows[] = $row;
					}
					$row = array();
					$col = 0;
					$row_count++;
				}			
				
			// append character to current field
			} else {
				$current .= $ch;
			}
		}
		$this->titles = $head;
		if ( !empty($this->sort_by) ) {
			( $this->sort_reverse ) ? krsort($rows) : ksort($rows) ;
		}
		return $rows;
	}
	
	/**
	 * Create CSV data from array
	 * @param   data        2D array with data
	 * @param   fields      field names
	 * @param   append      if true, field names will not be output
	 * @param   is_php      if a php die() call should be put on the first
	 *                      line of the file, this is later ignored when read.
	 * @param   delimiter   field delimiter to use
	 * @return  CSV data (text string)
	 */
	function unparse ( $data = array(), $fields = array(), $append = false , $is_php = false, $delimiter = null) {
		if ( !is_array($data) || empty($data) ) $data = &$this->data;
		if ( !is_array($fields) || empty($fields) ) $fields = &$this->titles;
		if ( $delimiter === null ) $delimiter = $this->delimiter;
		
		$string = ( $is_php ) ? "<?php header('Status: 403'); die(' '); ?>".$this->linefeed : '' ;
		$entry = array();
		
		// create heading
		if ( $this->heading && !$append ) {
			foreach( $fields as $key => $value ) {
				$entry[] = $this->enclose_value($value);
			}
			$string .= implode($delimiter, $entry).$this->linefeed;
			$entry = array();
		}
		
		// create data
		foreach( $data as $key => $row ) {
			foreach( $row as $field => $value ) {
				$entry[] = $this->enclose_value($value);
			}
			$string .= implode($delimiter, $entry).$this->linefeed;
			$entry = array();
		}
		
		return $string;
	}
	
	
	// ==============================================
	// ----- [ Internal Functions ] -----------------
	// ==============================================
	
	/**
	 * Enclose values if needed
	 *  - only used by unparse()
	 * @param   value   string to process
	 * @return  Processed value
	 */
	function enclose_value ($value = null) {
		$delimiter = preg_quote($this->delimiter, '/');
		$enclosure = preg_quote($this->enclosure, '/');
		if ( preg_match("/".$delimiter."|".$enclosure."|\n|\r/i", $value) ) {
			$value = str_replace($this->enclosure, $this->enclosure.$this->enclosure, $value);
			$value = $this->enclosure.$value.$this->enclosure;
		}
		return $value;
	}
	
	/**
	 * Check file data
	 * @param   file   local filename
	 * @return  true or false
	 */
	function check_data ($file = null) {
		if ( empty($this->file_data) ) {
			if ( $file === null ) $file = $this->file;
			return $this->load_data($file);
		}
		return true;
	}
	
	
	/**
	 * Check if passed info might be delimiter
	 *  - only used by find_delimiter()
	 * @return  special string used for delimiter selection, or false
	 */
	function check_count ($char, $array, $depth, $prefered) {
		if ( $depth == count($array) ) {
			$first = null;
			$equal = null;
			$almost = false;
			foreach( $array as $key => $value ) {
				if ( $first == null ) {
					$first = $value;
				} elseif ( $value == $first && $equal !== false) {
					$equal = true;
				} elseif ( $value == $first+1 && $equal !== false ) {
					$equal = true;
					$almost = true;
				} else {
					$equal = false;
				}
			}
			if ( $equal ) {
				$match = ( $almost ) ? 2 : 1 ;
				$pref = strpos($prefered, $char);
				$pref = ( $pref !== false ) ? str_pad($pref, 3, '0', STR_PAD_LEFT) : '999' ;
				return $pref.$match.'.'.(99999 - str_pad($first, 5, '0', STR_PAD_LEFT));
			} else return false;
		}
	}
	
	/**
	 * Read local file
	 * @param   file   local filename
	 * @return  Data from file, or false on failure
	 */
	function rfile ($file = null){
		if ( is_readable($file) ) {
			if ( !($fh = fopen($file, 'r')) ) return false;
			$data = fread($fh, filesize($file));
			fclose($fh);
			return $data;
		}
		return false;
	}

	/**
	 * Write to local file
	 * @param   file     local filename
	 * @param   string   data to write to file
	 * @param   mode     fopen() mode
	 * @param   lock     flock() mode
	 * @return  true or false
	 */
	function wfile($file, $string = '', $mode = 'wb', $lock = 2){
		if ( $fp = fopen($file, $mode) ) {
			flock($fp, $lock);
			$re = fwrite($fp, $string);
			$re2 = fclose($fp);
			if ( $re != false && $re2 != false ) return true;
		}
		return false;
	}
	
}

?>