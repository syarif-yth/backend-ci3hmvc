<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('tree_view')) {
	function tree_view($data)
	{
		style();
		print('<div class="tree">');
		html($data);
		print('</div>');
		script();
	}

	function html($data)
	{
		do {
			print('<ul>');
			foreach($data as $key => $val) {
				if(is_array($val)) {
					$click = "link_drop()";
					print('<li class="link">
						<a class="caret">
						'.$key.' ('.count($val).')</a>');
					html($val);
					print('</li>');
				} else {
					print('<li>'.$key.' : "'.$val.'"</li>');
				}
			}
			print('</ul>');
		} while (!is_array($data));
	}

	function style()
	{
		?>
    <style>
		.tree ul { 
			line-height: 1.7em; 
			list-style-type: none;
			padding-inline-start: 1.5em;
		}
		.tree li:before {
			content:"·";
			font-size: 3em;
			vertical-align: middle;
			margin-right: 10px;
		}
		.tree ul li.link a {
			font-weight: 600;
			line-height: 2em;
			letter-spacing: 0.1em;
		}
		.tree ul li.link a { text-decoration: none; }
		.tree ul li.link a:hover { 
			text-decoration: underline; 
			cursor: pointer; 
		}
		/* IF READY SHOW REMOVE THIS */
		.tree .link ul { display: none }
		.hide { display: none; }
		.show { display: block !important; }
    </style>
    <?php
	}

	function script()
	{
		?> <script> 
		var toggler = document.getElementsByClassName("caret");
		var i;
		for (i = 0; i < toggler.length; i++) {
			toggler[i].addEventListener("click", function() {
				this.parentElement.querySelector("ul").classList.toggle("show");
				// this.parentElement.querySelector("ul").classList.toggle("hide");
			});
		}
		</script> <?php
	}
}
?>
