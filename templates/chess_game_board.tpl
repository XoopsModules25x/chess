<{if $can_move}>
	<script type="text/javascript" language="javascript">

	<{* class tile - encapsulates tile-highlighting *}>
	function tile() {
		this.highlight      = highlight;
		this.unhighlight    = unhighlight;
	   this.image_tag_name = '';
	   this.piece_name     = '';
	}

	<{* method tile::highlight *}>
	function highlight(image_tag_name, piece_name) {
	   this.image_tag_name = image_tag_name;
	   this.piece_name     = piece_name;
		window.document.images[this.image_tag_name].src = 'images/wcg/' + this.piece_name + '_h.gif';
	}

	<{* method tile::unhighlight *}>
	function unhighlight() {
		if (this.image_tag_name && this.piece_name) {
			window.document.images[this.image_tag_name].src = 'images/wcg/' + this.piece_name + '.gif';
		}
	   this.image_tag_name = '';
	   this.piece_name     = '';
	}

	<{* Tile containing piece to move *}>
	highlighted_tile_1 = new tile();

	<{* Destination tile *}>
	highlighted_tile_2 = new tile();

	<{* Unhighlight all highlighted tiles (if any). *}>
	function unhighlight_all_tiles() {
		highlighted_tile_1.unhighlight();
		highlighted_tile_2.unhighlight();
	}

	<{* onClick event handler for board tiles *}>
	<{* Constructs move text and places it in form textbox, and highlights/unhighlights clicked tiles. *}>
	function assembleCmd(part, image_tag_name, piece_name)
	{
		var cmd = window.document.cmdform.chessmove.value;
		if (cmd == part) {
			window.document.cmdform.chessmove.value = "";
			unhighlight_all_tiles();
		} else {
			if (cmd.length == 0 || cmd.length >= 6) {
				<{* textbox empty or contains complete move *}>
				if (part.charAt(0) != '-' && part.charAt(0) != 'x') {
					window.document.cmdform.chessmove.value = part;
					unhighlight_all_tiles();
					highlighted_tile_1.highlight(image_tag_name, piece_name);
				}
			} else {
				if (part.charAt(0) == '-' || part.charAt(0) == 'x') {
					<{* textbox contains partial move, clicked on empty tile or tile containing opponent's piece *}>
					if (part.charAt(0) == '-' && cmd.charAt(0) == 'P' && cmd.charAt(1) != part.charAt(1)) {
						<{* pawn move to different file - interpret as capture, to handle possible en passant capture *}>
						part = part.replace('-', 'x');
					}
					window.document.cmdform.chessmove.value = cmd + part;
					highlighted_tile_2.highlight(image_tag_name, piece_name);
					if (cmd.charAt(0) == 'P' && (part.charAt(2) == 1 || part.charAt(2) == 8)) {
						<{* pawn move to first or last rank -  popup window for selecting piece to which pawn is promoted *}>
						w = window.open('', 'pawn_promotion', 'width=180,height=36,left=300,top=300');
						w.document.write('<{$chess_pawn_promote_popup|strip}>');
					}
				} else {
					<{* textbox contains partial move, clicked on tile containing own piece *}>
					window.document.cmdform.chessmove.value = part;
					unhighlight_all_tiles();
					highlighted_tile_1.highlight(image_tag_name, piece_name);
				}
			}
		}
		return false;
	}

	</script>
<{/if}>

<{* Initialize rank_counter. *}>
<{* rank_counter is used for providing rank labels, and is used in combination with file_counter to determine tile color
and tile coordinates. *}>
<{counter name=rank_counter assign=rank_count start=$chess_rank_start direction=$chess_rank_direction print=false}>

<{* outer table provides background coloring *}>
<table class="chessBoard" cellpadding="4" cellspacing="0">
<tr>
	<td class="even">

	<{* inner table contains chess board *}>
	<table class="chessBoard" cellpadding="0" cellspacing="0">

	<{foreach from=$chess_tiles item=rank}>
		<tr>
			<td class="chessLabel"><{$rank_count}></td>
			<td>&nbsp;</td>

			<{* Initialize file_counter. *}>
			<{* file_counter is used in combination with rank_counter to determine tile color and tile coordinates. *}>
			<{counter name=file_counter assign=file_count start=$chess_file_start direction=$chess_file_direction print=false}>

			<{foreach from=$rank item=piece}>

				<{if ($rank_count + $file_count) % 2 eq 1}>
					<{assign var='bgstyle' value='chessWhitetile'}>
				<{else}>
					<{assign var='bgstyle' value='chessBlacktile'}>
				<{/if}>

				<{* get file-rank coordinates 'fr' of tile (example: 'c5') *}>
				<{php}>
					global $xoopsTpl;
					$xoopsTpl->assign('fr', (chr(ord('a') + $xoopsTpl->get_template_vars('file_count') - 1)) . $xoopsTpl->get_template_vars('rank_count'));
				<{/php}>

				<td class="<{$bgstyle}>" style="text-align:center">

					<{if $piece eq 'x'}>

						<{* empty tile *}>
						<{assign var=cmd value='-'|cat:$fr}> <{* example: '-c5' *}>

					<{elseif $chess_pieces[$piece].color eq $chess_gamedata.fen_active_color}>

						<{* tile occupied by active player's piece *}>
						<{assign var=cmd value=$piece|upper|cat:$fr}> <{* example: 'Bc5' *}>

					<{else}>

						<{* tile occupied by opponent's piece *}>
						<{assign var=cmd value='x'|cat:$fr}> <{* example: 'xc5' *}>

					<{/if}>

					<{if $can_move}>
						<script type="text/javascript">
							window.document.write('<a href="javascript:void(0)" onClick="return assembleCmd(\'<{$cmd}>\', \'<{$fr}>\', \'<{$chess_pieces[$piece].name}>\');">');
						</script>
					<{/if}>

					<img name="<{$fr}>" border="0" width="36" height="36" alt="<{$chess_pieces[$piece].alt}>" src="images/wcg/<{$chess_pieces[$piece].name}>.gif" />

					<{if $can_move}>
						<script type="text/javascript">
							window.document.write('</a>');
						</script>
					<{/if}>

				</td>

				<{counter name=file_counter assign=file_count}> <{* increment or decrement *}>

			<{/foreach}>

		<td><img width="4" src="images/spacer.gif" alt="spacer" /></td>
		</tr>

		<{counter name=rank_counter assign=rank_count}> <{* increment or decrement *}>

	<{/foreach}>

	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<{foreach from=$chess_file_labels item=file_label}>
			<td style="text-align:center"><img height="4" src="images/spacer.gif" alt="spacer" /><br /><div class="chessLabel"><{$file_label}></div></td>
		<{/foreach}>

	</tr>

	</table>

	</td>
</tr>
</table>

