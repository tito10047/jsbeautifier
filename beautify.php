<?php
/**
 * Created by PhpStorm.
 * User: Jozef Môstka
 * Date: 27.5.2016
 * Time: 9:01
 */
namespace beautify\utils{
	/**
	 * Class RegExp
	 * @package beautify\utils
	 * @property string source
	 */
	class RegExp{
		private $regexp="";
		private $modifier="";
		function __construct($regexp,$modifier="") {
			$this->regexp=$regexp;
			$this->modifier=$modifier;
		}

		/**
		 * @param $regexp
		 * @param $modifier
		 */
		function compile($regexp,$modifier){

		}
		/**
		 * @param string $string
		 * @return array|{index:number, input:string}}
		 */
		function exec($string){

		}
		/**
		 * @param string $string
		 * @return boolean
		 */
		function test($string){

		}
		function toString(){

		}
		function __get($name) {
			switch ($name){
				case "source": return $this->regexp;
			}
			return null;
		}
	}
}
namespace beautify\acorn{

	const INIT=true;

	use beautify\utils\RegExp;

	global $nonASCIIidentifierStart, $nonASCIIidentifier, $lineBreak;

	$nonASCIIwhitespace = new RegExp('/[\u1680\u180e\u2000-\u200a\u202f\u205f\u3000\ufeff]/'); // jshint ignore:line
	$nonASCIIidentifierStartChars = '\xaa\xb5\xba\xc0-\xd6\xd8-\xf6\xf8-\u02c1\u02c6-\u02d1\u02e0-\u02e4\u02ec\u02ee\u0370-\u0374\u0376\u0377\u037a-\u037d\u0386\u0388-\u038a\u038c\u038e-\u03a1\u03a3-\u03f5\u03f7-\u0481\u048a-\u0527\u0531-\u0556\u0559\u0561-\u0587\u05d0-\u05ea\u05f0-\u05f2\u0620-\u064a\u066e\u066f\u0671-\u06d3\u06d5\u06e5\u06e6\u06ee\u06ef\u06fa-\u06fc\u06ff\u0710\u0712-\u072f\u074d-\u07a5\u07b1\u07ca-\u07ea\u07f4\u07f5\u07fa\u0800-\u0815\u081a\u0824\u0828\u0840-\u0858\u08a0\u08a2-\u08ac\u0904-\u0939\u093d\u0950\u0958-\u0961\u0971-\u0977\u0979-\u097f\u0985-\u098c\u098f\u0990\u0993-\u09a8\u09aa-\u09b0\u09b2\u09b6-\u09b9\u09bd\u09ce\u09dc\u09dd\u09df-\u09e1\u09f0\u09f1\u0a05-\u0a0a\u0a0f\u0a10\u0a13-\u0a28\u0a2a-\u0a30\u0a32\u0a33\u0a35\u0a36\u0a38\u0a39\u0a59-\u0a5c\u0a5e\u0a72-\u0a74\u0a85-\u0a8d\u0a8f-\u0a91\u0a93-\u0aa8\u0aaa-\u0ab0\u0ab2\u0ab3\u0ab5-\u0ab9\u0abd\u0ad0\u0ae0\u0ae1\u0b05-\u0b0c\u0b0f\u0b10\u0b13-\u0b28\u0b2a-\u0b30\u0b32\u0b33\u0b35-\u0b39\u0b3d\u0b5c\u0b5d\u0b5f-\u0b61\u0b71\u0b83\u0b85-\u0b8a\u0b8e-\u0b90\u0b92-\u0b95\u0b99\u0b9a\u0b9c\u0b9e\u0b9f\u0ba3\u0ba4\u0ba8-\u0baa\u0bae-\u0bb9\u0bd0\u0c05-\u0c0c\u0c0e-\u0c10\u0c12-\u0c28\u0c2a-\u0c33\u0c35-\u0c39\u0c3d\u0c58\u0c59\u0c60\u0c61\u0c85-\u0c8c\u0c8e-\u0c90\u0c92-\u0ca8\u0caa-\u0cb3\u0cb5-\u0cb9\u0cbd\u0cde\u0ce0\u0ce1\u0cf1\u0cf2\u0d05-\u0d0c\u0d0e-\u0d10\u0d12-\u0d3a\u0d3d\u0d4e\u0d60\u0d61\u0d7a-\u0d7f\u0d85-\u0d96\u0d9a-\u0db1\u0db3-\u0dbb\u0dbd\u0dc0-\u0dc6\u0e01-\u0e30\u0e32\u0e33\u0e40-\u0e46\u0e81\u0e82\u0e84\u0e87\u0e88\u0e8a\u0e8d\u0e94-\u0e97\u0e99-\u0e9f\u0ea1-\u0ea3\u0ea5\u0ea7\u0eaa\u0eab\u0ead-\u0eb0\u0eb2\u0eb3\u0ebd\u0ec0-\u0ec4\u0ec6\u0edc-\u0edf\u0f00\u0f40-\u0f47\u0f49-\u0f6c\u0f88-\u0f8c\u1000-\u102a\u103f\u1050-\u1055\u105a-\u105d\u1061\u1065\u1066\u106e-\u1070\u1075-\u1081\u108e\u10a0-\u10c5\u10c7\u10cd\u10d0-\u10fa\u10fc-\u1248\u124a-\u124d\u1250-\u1256\u1258\u125a-\u125d\u1260-\u1288\u128a-\u128d\u1290-\u12b0\u12b2-\u12b5\u12b8-\u12be\u12c0\u12c2-\u12c5\u12c8-\u12d6\u12d8-\u1310\u1312-\u1315\u1318-\u135a\u1380-\u138f\u13a0-\u13f4\u1401-\u166c\u166f-\u167f\u1681-\u169a\u16a0-\u16ea\u16ee-\u16f0\u1700-\u170c\u170e-\u1711\u1720-\u1731\u1740-\u1751\u1760-\u176c\u176e-\u1770\u1780-\u17b3\u17d7\u17dc\u1820-\u1877\u1880-\u18a8\u18aa\u18b0-\u18f5\u1900-\u191c\u1950-\u196d\u1970-\u1974\u1980-\u19ab\u19c1-\u19c7\u1a00-\u1a16\u1a20-\u1a54\u1aa7\u1b05-\u1b33\u1b45-\u1b4b\u1b83-\u1ba0\u1bae\u1baf\u1bba-\u1be5\u1c00-\u1c23\u1c4d-\u1c4f\u1c5a-\u1c7d\u1ce9-\u1cec\u1cee-\u1cf1\u1cf5\u1cf6\u1d00-\u1dbf\u1e00-\u1f15\u1f18-\u1f1d\u1f20-\u1f45\u1f48-\u1f4d\u1f50-\u1f57\u1f59\u1f5b\u1f5d\u1f5f-\u1f7d\u1f80-\u1fb4\u1fb6-\u1fbc\u1fbe\u1fc2-\u1fc4\u1fc6-\u1fcc\u1fd0-\u1fd3\u1fd6-\u1fdb\u1fe0-\u1fec\u1ff2-\u1ff4\u1ff6-\u1ffc\u2071\u207f\u2090-\u209c\u2102\u2107\u210a-\u2113\u2115\u2119-\u211d\u2124\u2126\u2128\u212a-\u212d\u212f-\u2139\u213c-\u213f\u2145-\u2149\u214e\u2160-\u2188\u2c00-\u2c2e\u2c30-\u2c5e\u2c60-\u2ce4\u2ceb-\u2cee\u2cf2\u2cf3\u2d00-\u2d25\u2d27\u2d2d\u2d30-\u2d67\u2d6f\u2d80-\u2d96\u2da0-\u2da6\u2da8-\u2dae\u2db0-\u2db6\u2db8-\u2dbe\u2dc0-\u2dc6\u2dc8-\u2dce\u2dd0-\u2dd6\u2dd8-\u2dde\u2e2f\u3005-\u3007\u3021-\u3029\u3031-\u3035\u3038-\u303c\u3041-\u3096\u309d-\u309f\u30a1-\u30fa\u30fc-\u30ff\u3105-\u312d\u3131-\u318e\u31a0-\u31ba\u31f0-\u31ff\u3400-\u4db5\u4e00-\u9fcc\ua000-\ua48c\ua4d0-\ua4fd\ua500-\ua60c\ua610-\ua61f\ua62a\ua62b\ua640-\ua66e\ua67f-\ua697\ua6a0-\ua6ef\ua717-\ua71f\ua722-\ua788\ua78b-\ua78e\ua790-\ua793\ua7a0-\ua7aa\ua7f8-\ua801\ua803-\ua805\ua807-\ua80a\ua80c-\ua822\ua840-\ua873\ua882-\ua8b3\ua8f2-\ua8f7\ua8fb\ua90a-\ua925\ua930-\ua946\ua960-\ua97c\ua984-\ua9b2\ua9cf\uaa00-\uaa28\uaa40-\uaa42\uaa44-\uaa4b\uaa60-\uaa76\uaa7a\uaa80-\uaaaf\uaab1\uaab5\uaab6\uaab9-\uaabd\uaac0\uaac2\uaadb-\uaadd\uaae0-\uaaea\uaaf2-\uaaf4\uab01-\uab06\uab09-\uab0e\uab11-\uab16\uab20-\uab26\uab28-\uab2e\uabc0-\uabe2\uac00-\ud7a3\ud7b0-\ud7c6\ud7cb-\ud7fb\uf900-\ufa6d\ufa70-\ufad9\ufb00-\ufb06\ufb13-\ufb17\ufb1d\ufb1f-\ufb28\ufb2a-\ufb36\ufb38-\ufb3c\ufb3e\ufb40\ufb41\ufb43\ufb44\ufb46-\ufbb1\ufbd3-\ufd3d\ufd50-\ufd8f\ufd92-\ufdc7\ufdf0-\ufdfb\ufe70-\ufe74\ufe76-\ufefc\uff21-\uff3a\uff41-\uff5a\uff66-\uffbe\uffc2-\uffc7\uffca-\uffcf\uffd2-\uffd7\uffda-\uffdc';
	$nonASCIIidentifierChars = '\u0300-\u036f\u0483-\u0487\u0591-\u05bd\u05bf\u05c1\u05c2\u05c4\u05c5\u05c7\u0610-\u061a\u0620-\u0649\u0672-\u06d3\u06e7-\u06e8\u06fb-\u06fc\u0730-\u074a\u0800-\u0814\u081b-\u0823\u0825-\u0827\u0829-\u082d\u0840-\u0857\u08e4-\u08fe\u0900-\u0903\u093a-\u093c\u093e-\u094f\u0951-\u0957\u0962-\u0963\u0966-\u096f\u0981-\u0983\u09bc\u09be-\u09c4\u09c7\u09c8\u09d7\u09df-\u09e0\u0a01-\u0a03\u0a3c\u0a3e-\u0a42\u0a47\u0a48\u0a4b-\u0a4d\u0a51\u0a66-\u0a71\u0a75\u0a81-\u0a83\u0abc\u0abe-\u0ac5\u0ac7-\u0ac9\u0acb-\u0acd\u0ae2-\u0ae3\u0ae6-\u0aef\u0b01-\u0b03\u0b3c\u0b3e-\u0b44\u0b47\u0b48\u0b4b-\u0b4d\u0b56\u0b57\u0b5f-\u0b60\u0b66-\u0b6f\u0b82\u0bbe-\u0bc2\u0bc6-\u0bc8\u0bca-\u0bcd\u0bd7\u0be6-\u0bef\u0c01-\u0c03\u0c46-\u0c48\u0c4a-\u0c4d\u0c55\u0c56\u0c62-\u0c63\u0c66-\u0c6f\u0c82\u0c83\u0cbc\u0cbe-\u0cc4\u0cc6-\u0cc8\u0cca-\u0ccd\u0cd5\u0cd6\u0ce2-\u0ce3\u0ce6-\u0cef\u0d02\u0d03\u0d46-\u0d48\u0d57\u0d62-\u0d63\u0d66-\u0d6f\u0d82\u0d83\u0dca\u0dcf-\u0dd4\u0dd6\u0dd8-\u0ddf\u0df2\u0df3\u0e34-\u0e3a\u0e40-\u0e45\u0e50-\u0e59\u0eb4-\u0eb9\u0ec8-\u0ecd\u0ed0-\u0ed9\u0f18\u0f19\u0f20-\u0f29\u0f35\u0f37\u0f39\u0f41-\u0f47\u0f71-\u0f84\u0f86-\u0f87\u0f8d-\u0f97\u0f99-\u0fbc\u0fc6\u1000-\u1029\u1040-\u1049\u1067-\u106d\u1071-\u1074\u1082-\u108d\u108f-\u109d\u135d-\u135f\u170e-\u1710\u1720-\u1730\u1740-\u1750\u1772\u1773\u1780-\u17b2\u17dd\u17e0-\u17e9\u180b-\u180d\u1810-\u1819\u1920-\u192b\u1930-\u193b\u1951-\u196d\u19b0-\u19c0\u19c8-\u19c9\u19d0-\u19d9\u1a00-\u1a15\u1a20-\u1a53\u1a60-\u1a7c\u1a7f-\u1a89\u1a90-\u1a99\u1b46-\u1b4b\u1b50-\u1b59\u1b6b-\u1b73\u1bb0-\u1bb9\u1be6-\u1bf3\u1c00-\u1c22\u1c40-\u1c49\u1c5b-\u1c7d\u1cd0-\u1cd2\u1d00-\u1dbe\u1e01-\u1f15\u200c\u200d\u203f\u2040\u2054\u20d0-\u20dc\u20e1\u20e5-\u20f0\u2d81-\u2d96\u2de0-\u2dff\u3021-\u3028\u3099\u309a\ua640-\ua66d\ua674-\ua67d\ua69f\ua6f0-\ua6f1\ua7f8-\ua800\ua806\ua80b\ua823-\ua827\ua880-\ua881\ua8b4-\ua8c4\ua8d0-\ua8d9\ua8f3-\ua8f7\ua900-\ua909\ua926-\ua92d\ua930-\ua945\ua980-\ua983\ua9b3-\ua9c0\uaa00-\uaa27\uaa40-\uaa41\uaa4c-\uaa4d\uaa50-\uaa59\uaa7b\uaae0-\uaae9\uaaf2-\uaaf3\uabc0-\uabe1\uabec\uabed\uabf0-\uabf9\ufb20-\ufb28\ufe00-\ufe0f\ufe20-\ufe26\ufe33\ufe34\ufe4d-\ufe4f\uff10-\uff19\uff3f';
	$nonASCIIidentifierStart = new RegExp("/[" . $nonASCIIidentifierStartChars . "]/");
	$nonASCIIidentifier = new RegExp("[/" . $nonASCIIidentifierStartChars . $nonASCIIidentifierChars . "]/");

	$newline = new RegExp('/[\n\r\u2028\u2029]/');

	$lineBreak = new RegExp('\r\n|' . $newline->source);
	$allLineBreaks = new RegExp($lineBreak->source, 'g');

	function isIdentifierStart($code) {
		global $nonASCIIidentifierStart;
		// permit $ (36) and @ (64). @ is used in ES7 decorators.
		if ($code < 65) return $code === 36 || $code === 64;
		// 65 through 91 are uppercase letters.
		if ($code < 91) return true;
		// permit _ (95).
		if ($code < 97) return $code === 95;
		// 97 through 123 are lowercase letters.
		if ($code < 123) return true;
		return $code >= 0xaa && $nonASCIIidentifierStart->test(chr($code));
	};

	function isIdentifierChar($code) {
		global $nonASCIIidentifier;
		if ($code < 48) return $code === 36;
		if ($code < 58) return true;
		if ($code < 65) return false;
		if ($code < 91) return true;
		if ($code < 97) return $code === 95;
		if ($code < 123) return true;
		return $code >= 0xaa && $nonASCIIidentifier->test(chr($code));
	};
}
namespace beautify{

	\beautify\acorn\INIT;

	function js_beautify($js_source_text, $options) {
		$beautifier = new Beautifier($js_source_text, $options);
		return $beautifier->beautify();
	}

	function sanitizeOperatorPosition($opPosition) {
		$opPosition = $opPosition || OPERATOR_POSITION["before_newline"];

		$validPositionValues = array_values(OPERATOR_POSITION);

		if (!in_array($opPosition, $validPositionValues)) {
			throw new \Error("Invalid Option Value: The option 'operator_position' must be one of the following values\n" .
				$validPositionValues .
				"\nYou passed in: '" . $opPosition . "'");
		}

		return $opPosition;
	}

	const OPERATOR_POSITION = [
		"before_newline"=> 'before-newline',
        "after_newline"=> 'after-newline',
        "preserve_newline"=> 'preserve-newline'
    ];

    const OPERATOR_POSITION_BEFORE_OR_PRESERVE = [OPERATOR_POSITION["before_newline"], OPERATOR_POSITION["preserve_newline"]];

    class MODE{
		const BlockStatement = 'BlockStatement', // 'BLOCK'
		Statement = 'Statement', // 'STATEMENT'
		ObjectLiteral = 'ObjectLiteral', // 'OBJECT',
		ArrayLiteral = 'ArrayLiteral', //'[EXPRESSION]',
		ForInitializer = 'ForInitializer', //'(FOR-EXPRESSION)',
		Conditional = 'Conditional', //'(COND-EXPRESSION)',
		Expression = 'Expression'; //'(EXPRESSION)'
	}
	
	class Beautifier{
		/** @var Output */
		private $output;
		private $tokens = [] ,$token_pos;
		private $Tokenizer;
		private $current_token;
		private $last_type, $last_last_text, $indent_string;
		private $flags, $previous_flags, $flag_store;
		private $prefix;

		private $opt;
		private $baseIndentString = '';

		private $js_source_text;
		
		
		
		private $handlers = [
            'TK_START_EXPR' => "handle_start_expr",
            'TK_END_EXPR' => "handle_end_expr",
            'TK_START_BLOCK' => "handle_start_block",
            'TK_END_BLOCK' => "handle_end_block",
            'TK_WORD' => "handle_word",
            'TK_RESERVED' => "handle_word",
            'TK_SEMICOLON' => "handle_semicolon",
            'TK_STRING' => "handle_string",
            'TK_EQUALS' => "handle_equals",
            'TK_OPERATOR' => "handle_operator",
            'TK_COMMA' => "handle_comma",
            'TK_BLOCK_COMMENT' => "handle_block_comment",
            'TK_COMMENT' => "handle_comment",
            'TK_DOT' => "handle_dot",
            'TK_UNKNOWN' => "handle_unknown",
            'TK_EOF' => "handle_eof"
        ];

		/**
		 * Beautifier constructor.
		 * @param $options
		 */
		public function __construct($js_source_text, $options=[]) {
			$this->opt = [];

			if (!array_key_exists("braces_on_own_line",$options)){
				$this->opt["brace_style"]=@$options["braces_on_own_line"] ? "expand" : "collapse";
			}
			$this->opt["brace_style"] = @$options["brace_style"] ? $options["brace_style"] : ($this->opt["brace_style"] ? $this->opt["brace_style"] : "collapse");

			if ($this->opt["brace_style"] === "expand-strict") {
				$this->opt["brace_style"] = "expand";
			}
			$this->opt=array_merge($this->opt,[
				"indent_size" => @$options["indent_size"] ? (int)($options["indent_size"]) : 4,
				"indent_char" => @$options["indent_char"] ? $options["indent_char"] : ' ',
				"eol" =>  $options["eol"] ?  $options["eol"] : 'auto',
				"preserve_newlines" => ( !isset($options["preserve_newlines"]) ) ? true :  $options["preserve_newlines"],
				"break_chained_methods" => ( !isset($options["break_chained_methods"])) ? false :  $options["break_chained_methods"],
				"max_preserve_newlines" => ( !isset($options["max_preserve_newlines"])) ? 0 : (int)( $options["max_preserve_newlines"]),
				"space_in_paren" => ( !isset($options["space_in_paren"])) ? false :  $options["space_in_paren"],
				"space_in_empty_paren" => ( !isset($options["space_in_empty_paren"])) ? false :  $options["space_in_empty_paren"],
				"jslint_happy" => ( !isset($options["jslint_happy"])) ? false :  $options["jslint_happy"],
				"space_after_anon_function" => ( !isset($options["space_after_anon_function"])) ? false :  $options["space_after_anon_function"],
				"keep_array_indentation" => ( !isset($options["keep_array_indentation"])) ? false :  $options["keep_array_indentation"],
				"space_before_conditional" => ( !isset($options["space_before_conditional"])) ? true :  $options["space_before_conditional"],
				"unescape_strings" => ( !isset($options["unescape_strings"])) ? false :  $options["unescape_strings"],
				"wrap_line_length" => ( !isset($options["wrap_line_length"])) ? 0 : (int)( $options["wrap_line_length"]),
				"e4x" => ( !isset($options["e4x"])) ? false :  $options["e4x"],
				"end_with_newline" => ( !isset($options["end_with_newline"])) ? false :  $options["end_with_newline"],
				"comma_first" => ( !isset($options["comma_first"])) ? false :  $options["comma_first"],
				"operator_position" => sanitizeOperatorPosition( $options["operator_position"]),
				"test_output_raw" => (!isset($options["test_output_raw"])) ? false : $options["test_output_raw"]
			]);
			if ($this->opt["jslint_happy"]) {
				$this->opt["space_after_anon_function"] = true;
			}

			if (@$options["indent_with_tabs"]) {
				$this->opt["indent_char"] = '\t';
				$this->opt["indent_size"] = 1;
			}

			global $lineBreak;

			if ($this->opt["eol"] === 'auto') {
				$this->opt["eol"] = '\n';
				if ($js_source_text && $lineBreak->test($js_source_text || '')) {
					preg_match($lineBreak->source,$js_source_text,$matches);
					$this->opt["eol"] = $matches[0];
				}
			}

			$this->opt["eol"] = preg_replace(["/\\r/","/\\n/"],['\r','\n'],$this->opt["eol"]);

			$indent_string = '';
			while ($this->opt["indent_size"] > 0) {
				$indent_string += $this->opt["indent_char"];
				$this->opt["indent_size"] -= 1;
			}

			$preindent_index = 0;
			if ($js_source_text && strlen($js_source_text)) {
				while (($js_source_text[$preindent_index] === ' ' ||
					$js_source_text[$preindent_index] === '\t')) {
					$this->baseIndentString += $js_source_text[$preindent_index];
					$preindent_index += 1;
				}
				$js_source_text = substr($js_source_text,$preindent_index);
			}

			$this->last_type = 'TK_START_BLOCK'; // last token type
			$this->last_last_text = ''; // pre-last token text
			$this->output = new Output($indent_string, $this->baseIndentString);
			$this->output->raw = $this->opt["test_output_raw"];

			$this->flag_store = [];

			$this->set_mode(MODE::BlockStatement);

			$this->js_source_text = $js_source_text;
		}

		private function create_flags(array $flags_base, $mode) {
			$next_indent_level = 0;
			if ($flags_base) {
				$next_indent_level = $flags_base["indentation_level"];
				if (!$this->output->just_added_newline() &&
					$flags_base["line_indent_level"] > $next_indent_level) {
					$next_indent_level = $flags_base["line_indent_level"];
				}
			}

			$next_flags = [
				"mode"=> $mode,
                "parent"=> $flags_base,
                "last_text"=> $flags_base ? $flags_base["last_text"] : '', // last token text
                "last_word"=> $flags_base ? $flags_base["last_word"] : '', // last 'TK_WORD' passed
                "declaration_statement"=> false,
                "declaration_assignment"=> false,
                "multiline_frame"=> false,
                "inline_frame"=> false,
                "if_block"=> false,
                "else_block"=> false,
                "do_block"=> false,
                "do_while"=> false,
                "import_block"=> false,
                "in_case_statement"=> false, // switch(..){ INSIDE HERE }
                "in_case"=> false, // we're on the exact line with case 0":"
                "case_body"=> false, // the indented case-action block
                "indentation_level"=> $next_indent_level,
                "line_indent_level"=> $flags_base ? $flags_base["line_indent_level"] : $next_indent_level,
                "start_line_index"=> $this->output->get_line_number(),
                "ternary_depth"=> 0
            ];
            return $next_flags;
		}

		public function beautify(){
			$this->Tokenizer = new tokenizer($this->js_source_text, $this->opt, $this->indent_string);
			$this->tokens = $this->Tokenizer.tokenize();
			$this->Tokenizer = 0;

			$local_token=null;

			function get_local_token() use(&$local_token) {
				$local_token = get_token();
				return $local_token;
			}

			while (get_local_token()) {
				for ($i = 0; $i < count($local_token->comments_before); $i++) {//TODO: check if comments_before is string or array
					// The cleanest handling of inline comments is to treat them as though they aren't there.
					// Just continue formatting and the behavior should be logical.
					// Also ignore unknown tokens.  Again, this should result in better behavior.
					$this->handle_token($local_token->comments_before[$i]);
				}
				$this->handle_token($local_token);

				$this->last_last_text = $this->flags->last_text;
				$this->last_type = $local_token->type;
				$this->flags->last_text = $local_token->text;

                $this->token_pos += 1;
            }

			$sweet_code = $this->output->get_code();
			if ($this->opt["end_with_newline"]) {
				$sweet_code .= '\n';
			}

			if ($this->opt["eol"] !== '\n') {
				$sweet_code = preg_replace("/[\n]/g", $this->opt["eol"],$sweet_code);
            }

			return $sweet_code;
		}

		private function handle_token($local_token){
			$newlines = $local_token->newlines;
			$keep_whitespace = $this->opt["keep_array_indentation"] && $this->is_array($this->flags->mode);

			if ($keep_whitespace) {
				for ($i = 0; $i < $newlines; $i += 1) {
					$this->print_newline($i > 0);
				}
            } else {
				if ($this->opt["max_preserve_newlines"] && $newlines > $this->opt["max_preserve_newlines"]) {
					$newlines = $this->opt["max_preserve_newlines"];
				}

				if ($this->opt["preserve_newlines"]) {
					if ($local_token->newlines > 1) {
						$this->print_newline();
						for ($j = 1; $j < $newlines; $j += 1) {
							$this->print_newline(true);
						}
                    }
				}
			}

			$this->current_token = $local_token;
			$this->handlers[$this->current_token->type]();
		}
		private function split_linebreaks($s) {
			//return s.split(/\x0d\x0a|\x0a/);
			global $allLineBreaks;
			$s = preg_replace($allLineBreaks->source,'\n',$s);
			$out = [];
			$idx = strpos($s,"\n");
            while ($idx !== -1) {
				$out[]=substr($s,0,$idx);
				$s = substr($s,$idx + 1);
				$idx = strpos($s,"\n");
			}
            if (strlen($s)) {
				$out[]=$s;
			}
            return $out;
        }

		private $newline_restricted_tokens = ['break', 'contiue', 'return', 'throw'];

		private function allow_wrap_or_preserved_newline($force_linewrap=null) {
			$force_linewrap = ($force_linewrap === null) ? false : $force_linewrap;

			// Never wrap the first token on a line
			if ($this->output->just_added_newline()) {
				return;
			}

			$shouldPreserveOrForce = ($this->opt["preserve_newlines"] && $this->current_token->wanted_newline) || force_linewrap;
			$operatorLogicApplies = in_array($this->flags->last_text, Tokenizer::$positionable_operators) || in_array($this->current_token->text, Tokenizer::$positionable_operators);

			if ($operatorLogicApplies) {
				$shouldPrintOperatorNewline = (
						in_array($this->flags->last_text, Tokenizer::$positionable_operators) &&
						in_array($this->opt["operator_position"], OPERATOR_POSITION_BEFORE_OR_PRESERVE)
					) ||
					in_array($this->current_token->text, Tokenizer::$positionable_operators);
				$shouldPreserveOrForce = $shouldPreserveOrForce && $shouldPrintOperatorNewline;
			}

			if ($shouldPreserveOrForce) {
				$this->print_newline(false, true);
			} else if ($this->opt["wrap_line_length"]) {
				if ($this->last_type === 'TK_RESERVED' && in_array($this->flags->last_text, $this->newline_restricted_tokens)) {
					// These tokens should never have a newline inserted
					// between them and the following expression.
					return;
				}
				$proposed_line_length = $this->output->current_line->get_character_count() + strlen($this->current_token->text) +
					($this->output->space_before_token ? 1 : 0);
				if ($proposed_line_length >= $this->opt["wrap_line_length"]) {
					$this->print_newline(false, true);
				}
			}
		}

		private function print_newline($force_newline=false, $preserve_statement_flags=false) {
			if (!$preserve_statement_flags) {
				if ($this->flags->last_text !== ';' && $this->flags->last_text !== ',' && $this->flags->last_text !== '=' && $this->last_type !== 'TK_OPERATOR') {
					while ($this->flags->mode === MODE::Statement && !$this->flags->if_block && !$this->flags->do_block) {
						$this->restore_mode();
					}
				}
			}

			if ($this->output->add_new_line($force_newline)) {
				$this->flags->multiline_frame = true;
			}
		}

		private function print_token($printable_token=null) {
			if ($this->output->raw) {
				$this->output->add_raw_token($this->current_token);
				return;
			}

			if ($this->opt["comma_first"] && $this->last_type === 'TK_COMMA' &&
				$this->output->just_added_newline()) {
				if ($this->output->previous_line->last() === ',') {
					$popped = $this->output->previous_line->pop();
					// if the comma was already at the start of the line,
					// pull back onto that line and reprint the indentation
					if ($this->output->previous_line->is_empty()) {
						$this->output->previous_line->push(popped);
						$this->output->trim(true);
						$this->output->current_line.pop();
						$this->output->trim();
					}

					// add the comma in front of the next token
					$this->print_token_line_indentation();
					$this->output->add_token(',');
					$this->output->space_before_token = true;
				}
			}

			$printable_token = $printable_token || $this->current_token->text;
			$this->print_token_line_indentation();
			$this->output->add_token($printable_token);
		}

		private function indent() {
			$this->flags->indentation_level += 1;
		}

		private function deindent() {
			if ($this->flags->indentation_level > 0 &&
				((!$this->flags->parent) || $this->flags->indentation_level > $this->flags->parent->indentation_level)) {
				$this->flags->indentation_level -= 1;
			}
		}

		private function set_mode($mode) {
			if ($this->flags) {
				$this->flag_store->push($this->flags);
				$this->previous_flags = $this->flags;
			} else {
				$this->previous_flags = $this->create_flags(null, $mode);
			}

			$this->flags = $this->create_flags($this->previous_flags, $mode);
		}
		
		private function is_array($mode) {
			return $mode === MODE::ArrayLiteral;
		}

		private function is_expression($mode) {
			return in_array($mode, [MODE::Expression, MODE::ForInitializer, MODE::Conditional]);
		}

		private function restore_mode() {
			if ($this->flag_store->length > 0) {
				$this->previous_flags = $this->flags;
				$this->flags = $this->flag_store->pop();
				if ($this->previous_flags->mode === MODE::Statement) {
					$this->output->remove_redundant_indentation($this->previous_flags);
				}
			}
		}

		function start_of_object_property() {
			return $this->flags->parent->mode === MODE::ObjectLiteral && $this->flags->mode === MODE::Statement && (
				($this->flags->last_text === ':' && $this->flags->ternary_depth === 0) || ($this->last_type === 'TK_RESERVED' && in_array($this->flags->last_text, ['get', 'set'])));
		}

		private function start_of_statement() {
			if (
				($this->last_type === 'TK_RESERVED' && in_array($this->flags-last_text, ['var', 'let', 'const']) && $this->current_token->type === 'TK_WORD') ||
				($this->last_type === 'TK_RESERVED' && $this->flags->last_text === 'do') ||
				($this->last_type === 'TK_RESERVED' && in_array($this->flags->last_text, ['return', 'throw']) && !$this->current_token->wanted_newline) ||
				($this->last_type === 'TK_RESERVED' && $this->flags->last_text === 'else' && !($this->current_token->type === 'TK_RESERVED' && $this->current_token->text === 'if')) ||
				($this->last_type === 'TK_END_EXPR' && ($this->previous_flags->mode === MODE::ForInitializer || $this->previous_flags->mode === MODE::Conditional)) ||
				($this->last_type === 'TK_WORD' && $this->flags->mode === MODE::BlockStatement && !$this->flags->in_case && !($this->current_token->text === '--' || $this->current_token->text === '++') &&
					$this->last_last_text !== 'function' &&
					$this->current_token->type !== 'TK_WORD' && $this->current_token->type !== 'TK_RESERVED') ||
				($this->flags->mode === MODE::ObjectLiteral && (
						($this->flags->last_text === ':' && $this->flags->ternary_depth === 0) || ($this->last_type === 'TK_RESERVED' && in_array($this->flags->last_text, ['get', 'set']))))
			) {

				$this->set_mode(MODE::Statement);
				$this->indent();

				if ($this->last_type === 'TK_RESERVED' && in_array($this->flags->last_text, ['var', 'let', 'const']) && $this->current_token->type === 'TK_WORD') {
					$this->flags->declaration_statement = true;
				}

				// Issue #276:
				// If starting a new statement with [if, for, while, do], push to a new line.
				// if (a) if (b) if(c) d(); else e(); else f();
				if (!$this->start_of_object_property()) {
					$this->allow_wrap_or_preserved_newline(
						$this->current_token->type === 'TK_RESERVED' && in_array($this->current_token->text, ['do', 'for', 'if', 'while']));
				}

				return true;
			}
			return false;
		}

		private function all_lines_start_with(array $lines, $c) {
			for ($i = 0; $i < count($lines); $i++) {
				$line = trim($lines[$i]);
				if (substr($line,0,1) !== $c) {
					return false;
				}
			}
            return true;
        }

		private function each_line_matches_indent(array $lines, $indent) {
			$i = 0;
			$len = count($lines);
			$line=0;
            for (; $i < $len; $i++) {
				$line = $lines[$i];
				// allow empty lines to pass through
				if ($line && strpos($line,$indent) !== 0) {
					return false;
				}
			}
            return true;
        }

		private function is_special_word($word) {
			return in_array($word, ['case', 'return', 'do', 'if', 'throw', 'else']);
		}

		private function get_token($offset) {
			$index = $this->token_pos + ($offset || 0);
			return ($index < 0 || $index >= count($this->tokens)) ? null : $this->tokens[$index];
		}

		private function handle_start_expr() {
			if ($this->start_of_statement()) {
				// The conditional starts the statement if appropriate.
			}

			$next_mode = MODE::Expression;
			if ($this->current_token->text === '[') {

				if ($this->last_type === 'TK_WORD' || $this->flags->last_text === ')') {
					// this is array index specifier, break immediately
					// a[x], fn()[x]
					if ($this->last_type === 'TK_RESERVED' && in_array($this->flags->last_text, Tokenizer::$line_starters)) {
						$this->output->space_before_token = true;
					}
					$this->set_mode($next_mode);
					$this->print_token();
					$this->indent();
					if ($this->opt["space_in_paren"]) {
						$this->output->space_before_token = true;
					}
					return;
				}

				$next_mode = MODE::ArrayLiteral;
				if ($this->is_array($this->flags->mode)) {
					if ($this->flags->last_text === '[' ||
						($this->flags->last_text === ',' && ($this->last_last_text === ']' || $this->last_last_text === '}'))) {
						// ], [ goes to new line
						// }, [ goes to new line
						if (!$this->opt->keep_array_indentation) {
							$this->print_newline();
						}
					}
				}

			} else {
				if ($this->last_type === 'TK_RESERVED' && $this->flags->last_text === 'for') {
					$next_mode = MODE::ForInitializer;
				} else if ($this->last_type === 'TK_RESERVED' && in_array($this->flags->last_text, ['if', 'while'])) {
					$next_mode = MODE::Conditional;
				} else {
					// next_mode = MODE.Expression;
				}
			}

			if ($this->flags->last_text === ';' || $this->last_type === 'TK_START_BLOCK') {
				$this->print_newline();
			} else if ($this->last_type === 'TK_END_EXPR' || $this->last_type === 'TK_START_EXPR' || $this->last_type === 'TK_END_BLOCK' || $this->flags->last_text === '.') {
				// TODO: Consider whether forcing this is required.  Review failing tests when removed.
				$this->allow_wrap_or_preserved_newline($this->current_token->wanted_newline);
				// do nothing on (( and )( and ][ and ]( and .(
			} else if (!($this->last_type === 'TK_RESERVED' && $this->current_token->text === '(') && $this->last_type !== 'TK_WORD' && $this->last_type !== 'TK_OPERATOR') {
				$this->output->space_before_token = true;
			} else if (($this->last_type === 'TK_RESERVED' && ($this->flags->last_word === 'function' || $this->flags->last_word === 'typeof')) ||
				($this->flags->last_text === '*' && $this->last_last_text === 'function')) {
				// function() vs function ()
				if ($this->opt["space_after_anon_function"]) {
					$this->output->space_before_token = true;
				}
			} else if ($this->last_type === 'TK_RESERVED' && (in_array($this->flags->last_text, Tokenizer::$line_starters) || $this->flags->last_text === 'catch')) {
				if ($this->opt["space_before_conditional"]) {
					$this->output->space_before_token = true;
				}
			}

			// Should be a space between await and an IIFE
			if ($this->current_token->text === '(' && $this->last_type === 'TK_RESERVED' && $this->flags->last_word === 'await') {
				$this->output->space_before_token = true;
			}

			// Support of this kind of newline preservation.
			// a = (b &&
			//     (c || d));
			if ($this->current_token->text === '(') {
				if ($this->last_type === 'TK_EQUALS' || $this->last_type === 'TK_OPERATOR') {
					if (!$this->start_of_object_property()) {
						$this->allow_wrap_or_preserved_newline();
					}
				}
			}

			// Support preserving wrapped arrow function expressions
			// a.b('c',
			//     () => d.e
			// )
			if ($this->current_token->text === '(' && $this->last_type !== 'TK_WORD' && $this->last_type !== 'TK_RESERVED') {
				$this->allow_wrap_or_preserved_newline();
			}

			$this->set_mode($next_mode);
			$this->print_token();
			if ($this->opt["space_in_paren"]) {
				$this->output->space_before_token = true;
			}

			// In all cases, if we newline while inside an expression it should be indented.
			$this->indent();
		}

		private function handle_start_block() {
			// Check if this is should be treated as a ObjectLiteral
			$next_token = $this->get_token(1);
			$second_token = $this->get_token(2);
			if ($second_token && (
					(in_array($second_token->text, [':', ',']) && in_array($next_token->type, ['TK_STRING', 'TK_WORD', 'TK_RESERVED'])) ||
					(in_array($next_token->text, ['get', 'set']) && in_array($second_token->type, ['TK_WORD', 'TK_RESERVED']))
				)) {
				// We don't support TypeScript,but we didn't break it for a very long time.
				// We'll try to keep not breaking it.
				if (!in_array($this->last_last_text, ['class', 'interface'])) {
					set_mode(MODE::ObjectLiteral);
				} else {
					set_mode(MODE::BlockStatement);
				}
			} else if ($this->last_type === 'TK_OPERATOR' && $this->flags->last_text === '=>') {
				// arrow function: (param1, paramN) => { statements }
				$this->set_mode(MODE::BlockStatement);
			} else if (in_array($this->last_type, ['TK_EQUALS', 'TK_START_EXPR', 'TK_COMMA', 'TK_OPERATOR']) ||
				($this->last_type === 'TK_RESERVED' && in_array($this->flags->last_text, ['return', 'throw', 'import']))
			) {
				// Detecting shorthand function syntax is difficult by scanning forward,
				//     so check the surrounding context.
				// If the block is being returned, imported, passed as arg,
				//     assigned with = or assigned in a nested object, treat as an ObjectLiteral.
				$this->set_mode(MODE::ObjectLiteral);
			} else {
				$this->set_mode(MODE::BlockStatement);
			}

			$empty_braces = !$next_token->comments_before->length && $next_token->text === '}';
			$empty_anonymous_function = $empty_braces && $this->flags->last_word === 'function' &&
				$this->last_type === 'TK_END_EXPR';


			if ($this->opt["brace_style"] === "expand" ||
				($this->opt["brace_style"] === "none" && $this->current_token->wanted_newline)) {
				if ($this->last_type !== 'TK_OPERATOR' &&
					($empty_anonymous_function ||
						$this->last_type === 'TK_EQUALS' ||
						($this->last_type === 'TK_RESERVED' && $this->is_special_word($this->flags->last_text) && $this->flags->last_text !== 'else'))) {
					$this->output->space_before_token = true;
				} else {
					$this->print_newline(false, true);
				}
			} else { // collapse
				if ($this->opt["brace_style"] === 'collapse-preserve-inline') {
					// search forward for a newline wanted inside this block
					$index = 0;
					$check_token = null;
					$this->flags->inline_frame = true;
					do {
						Tindex += 1;
						$check_token = $this->get_token(index);
						if ($check_token->wanted_newline) {
							$this->flags->inline_frame = false;
							break;
						}
					} while ($check_token->type !== 'TK_EOF' && !($check_token->type === 'TK_END_BLOCK' && $check_token->opened === $this->current_token));
				}

				if ($this->is_array($this->previous_flags->mode) && ($this->last_type === 'TK_START_EXPR' || $this->last_type === 'TK_COMMA')) {
					// if we're preserving inline,
					// allow newline between comma and next brace.
					if ($this->last_type === 'TK_COMMA' || $this->opt["space_in_paren"]) {
						$this->output->space_before_token = true;
					}

					if ($this->opt["brace_style"] === 'collapse-preserve-inline' &&
						($this->last_type === 'TK_COMMA' || ($this->last_type === 'TK_START_EXPR' && $this->flags->inline_frame))) {
						$this->allow_wrap_or_preserved_newline();
						$this->previous_flags->multiline_frame = $this->previous_flags->multiline_frame || $this->flags->multiline_frame;
						$this->flags->multiline_frame = false;
					}
				} else if ($this->last_type !== 'TK_OPERATOR' && $this->last_type !== 'TK_START_EXPR') {
					if ($this->last_type === 'TK_START_BLOCK') {
						$this->print_newline();
					} else {
						$this->output->space_before_token = true;
					}
				}
			}
			$this->print_token();
			$this->indent();
		}

		private function handle_end_block() {
			// statements must all be closed when their container closes
			while ($this->flags.mode === MODE::Statement) {
				$this->restore_mode();
			}
			$empty_braces = $this->last_type === 'TK_START_BLOCK';

			if ($this->opt->brace_style === "expand") {
				if (!$empty_braces) {
					$this->print_newline();
				}
			} else {
				// skip {}
				if (!$empty_braces) {
					if ($this->flags->inline_frame) {
						$this->output->space_before_token = true;
					} else if ($this->is_array($this->flags.mode) && $this->opt["keep_array_indentation"]) {
						// we REALLY need a newline here, but newliner would skip that
						$this->opt["keep_array_indentation"] = false;
						$this->print_newline();
						$this->opt["keep_array_indentation"] = true;

					} else {
						$this->print_newline();
					}
				}
			}
			$this->restore_mode();
			$this->print_token();
		}

	}
}