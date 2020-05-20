<a name="top"></a>

<table class="outer">

<{* -------------------- *}>

<tr><th>
<{$smarty.const._HE_CHESS_MAIN_TITLE}>
</th></tr>

<{* -------------------- *}>

<tr><td class="head">
<{$smarty.const._HE_CHESS_INTRO_TITLE}>
</td></tr>

<tr><td class="odd">
<a name="fide"></a>
<{$smarty.const._HE_CHESS_INTRO_010}>
</td></tr>

<{* -------------------- *}>

<tr><td class="head">
<{$smarty.const._HE_CHESS_CREATE_TITLE}>
</td></tr>

<tr><td class="odd">
<{$smarty.const._HE_CHESS_CREATE_010}>
<ul>
	<li><{$smarty.const._HE_CHESS_CREATE_010_1}></li>
	<li><{$smarty.const._HE_CHESS_CREATE_010_2}></li>
	<li><{$smarty.const._HE_CHESS_CREATE_010_3}></li>
</ul>
</td></tr>

<tr><td class="odd">
<{$smarty.const._HE_CHESS_CREATE_020}>
</td></tr>

<{if $chess_allow_setup}>
	<tr><td class="odd">
	<{$smarty.const._HE_CHESS_CREATE_030}>
	</td></tr>
<{/if}>

<tr><td class="odd">
<{$smarty.const._HE_CHESS_CREATE_040}>
</td></tr>

<{if $chess_rating_system != 'none' and $chess_allow_unrated_games}>
	<tr><td class="odd">
	<{$smarty.const._HE_CHESS_CREATE_050}>
	</td></tr>
<{/if}>

<tr><td class="odd">
<{$smarty.const._HE_CHESS_CREATE_060}>
</td></tr>

<tr><td class="odd">
<{$smarty.const._HE_CHESS_CREATE_070}>
</td></tr>

<{* -------------------- *}>

<{if $chess_rating_system != 'none'}>

	<tr><td class="head">
	<{$smarty.const._HE_CHESS_RATINGS_TITLE}>
	</td></tr>
	
	<tr><td class="odd">
	<{$chess_rating_system_des}>
	</td></tr>

<{/if}>

<{* -------------------- *}>

<tr><td class="head">
<{$smarty.const._HE_CHESS_PLAY_TITLE}>
</td></tr>

<tr><td class="odd">
<{$smarty.const._HE_CHESS_PLAY_010}>
<ul>
	<li><{$smarty.const._HE_CHESS_PLAY_010_1}></li>
	<li><{$smarty.const._HE_CHESS_PLAY_010_2}></li>
	<li><{$smarty.const._HE_CHESS_PLAY_010_3}></li>
	<li><{$smarty.const._HE_CHESS_PLAY_010_4}></li>
	<li><{$smarty.const._HE_CHESS_PLAY_010_5}></li>
	<li><{$smarty.const._HE_CHESS_PLAY_010_6}></li>
	<li><{$smarty.const._HE_CHESS_PLAY_010_7}></li>
	<li><{$smarty.const._HE_CHESS_PLAY_010_8}></li>
	<li><{$smarty.const._HE_CHESS_PLAY_010_9}></li>
</ul>
</td></tr>

<tr><td class="odd">
<{$smarty.const._HE_CHESS_PLAY_020}>
</td></tr>

<tr><td class="odd">
<{$smarty.const._HE_CHESS_PLAY_030}>
</td></tr>

<tr><td class="odd">
<{$smarty.const._HE_CHESS_PLAY_040}>
</td></tr>

<tr><td class="odd">
<{$smarty.const._HE_CHESS_PLAY_050}>
</td></tr>

<tr><td class="odd">
<{$smarty.const._HE_CHESS_PLAY_060}>
</td></tr>

<tr><td class="odd">
<{if $chess_allow_delete}>
	<{$smarty.const._HE_CHESS_PLAY_070}>
<{else}>
	<{$smarty.const._HE_CHESS_PLAY_075}>
<{/if}>
</td></tr>

<tr><td class="odd">
<{$smarty.const._HE_CHESS_PLAY_080}>
</td></tr>

<{* -------------------- *}>

<tr><td class="head">
<{$smarty.const._HE_CHESS_ARBITRATION_TITLE}>
</td></tr>

<tr><td class="odd">
<{$smarty.const._HE_CHESS_ARBITRATION_010}>
<ul>
	<li><{$smarty.const._HE_CHESS_ARBITRATION_010_1}></li>
	<li><{$smarty.const._HE_CHESS_ARBITRATION_010_2}></li>
	<li><{$smarty.const._HE_CHESS_ARBITRATION_010_3}></li>
</ul>
</td></tr>

<tr><td class="odd">
<{$smarty.const._HE_CHESS_ARBITRATION_020}>
</td></tr>

<{* -------------------- *}>

<tr><td class="head">
<{$smarty.const._HE_CHESS_DISPLAY_TITLE}>
</td></tr>

<tr><td class="odd">
<{$smarty.const._HE_CHESS_DISPLAY_010}>
<ul>
	<li><{$smarty.const._HE_CHESS_DISPLAY_010_1}></li>
	<li><{$smarty.const._HE_CHESS_DISPLAY_010_2}></li>
	<li><{$smarty.const._HE_CHESS_DISPLAY_010_3}></li>
</ul>
</td></tr>

<tr><td class="odd">
<{$smarty.const._HE_CHESS_DISPLAY_020}>
</td></tr>

<tr><td class="odd">
<{$smarty.const._HE_CHESS_DISPLAY_030}>
</td></tr>

<tr><td class="odd">
<{$smarty.const._HE_CHESS_DISPLAY_040}>
</td></tr>

<{* -------------------- *}>

<tr><td class="head">
<{$smarty.const._HE_CHESS_NOTIFY_TITLE}>
</td></tr>

<tr><td class="odd">
<{$smarty.const._HE_CHESS_NOTIFY_010}>
</td></tr>

<tr><td class="odd">
<{$smarty.const._HE_CHESS_NOTIFY_020}>
</td></tr>

<{* -------------------- *}>

<tr><td class="head">
<a name="moving"></a>
<{$smarty.const._HE_CHESS_MOUSE_TITLE}>
</td></tr>

<tr><td class="odd">
<{$smarty.const._HE_CHESS_MOUSE_010}>
</td></tr>

<tr><td class="odd">
<{$smarty.const._HE_CHESS_MOUSE_020}>
</td></tr>

<tr><td class="odd">
<{$smarty.const._HE_CHESS_MOUSE_030}>
</td></tr>

<{* -------------------- *}>

<tr><td class="head">
<{$smarty.const._HE_CHESS_NOTATION_TITLE}>
</td></tr>

<tr><td class="odd">
<{$smarty.const._HE_CHESS_NOTATION_010}>
</td></tr>

<tr><td class="odd">
<{$smarty.const._HE_CHESS_NOTATION_020}>
<ul>

	<li style="list-style-type: decimal;">
		<em><{$smarty.const._HE_CHESS_NOTATION_020_1}></em>

		<ul>
			<li><{$smarty.const._HE_CHESS_NOTATION_020_1_A}></li>
			<li><{$smarty.const._HE_CHESS_NOTATION_020_1_B}></li>
			<li><{$smarty.const._HE_CHESS_NOTATION_020_1_C}></li>
			<li><{$smarty.const._HE_CHESS_NOTATION_020_1_D}></li>
			<li><{$smarty.const._HE_CHESS_NOTATION_020_1_E}></li>
			<li><{$smarty.const._HE_CHESS_NOTATION_020_1_F}></li>
		</ul>
	</li>

	<li style="list-style-type: decimal;">
		<em><{$smarty.const._HE_CHESS_NOTATION_020_2}></em>

		<ul>
			<li><{$smarty.const._HE_CHESS_NOTATION_020_2_A}></li>
		</ul>
	</li>

	<li style="list-style-type: decimal;">
		<em><{$smarty.const._HE_CHESS_NOTATION_020_3}></em>

		<ul>
			<li><{$smarty.const._HE_CHESS_NOTATION_020_3_A}></li>
			<li><{$smarty.const._HE_CHESS_NOTATION_020_3_B}></li>
		</ul>
	</li>

	<li style="list-style-type: decimal;">
		<em><{$smarty.const._HE_CHESS_NOTATION_020_4}></em>

		<ul>
			<li><{$smarty.const._HE_CHESS_NOTATION_020_4_A}></li>
		</ul>
	</li>

	<li style="list-style-type: decimal;">
		<em><{$smarty.const._HE_CHESS_NOTATION_020_5}></em>

		<ul>
			<li><{$smarty.const._HE_CHESS_NOTATION_020_5_A}></li>
		</ul>
	</li>

</ul>
</td></tr>

<tr><td class="odd">
<{$smarty.const._HE_CHESS_NOTATION_030}>
<ul>
	<li><{$smarty.const._HE_CHESS_NOTATION_030_1|replace:' ':'&nbsp;'}></li>
	<li><{$smarty.const._HE_CHESS_NOTATION_030_2|replace:' ':'&nbsp;'}></li>
	<li><{$smarty.const._HE_CHESS_NOTATION_030_3|replace:' ':'&nbsp;'}></li>
	<li><{$smarty.const._HE_CHESS_NOTATION_030_4|replace:' ':'&nbsp;'}></li>
	<li><{$smarty.const._HE_CHESS_NOTATION_030_5|replace:' ':'&nbsp;'}></li>
	<li><{$smarty.const._HE_CHESS_NOTATION_030_6|replace:' ':'&nbsp;'}></li>
	<li><{$smarty.const._HE_CHESS_NOTATION_030_7|replace:' ':'&nbsp;'}></li>
</ul>
</td></tr>

<tr><td class="odd">
<{$smarty.const._HE_CHESS_NOTATION_040}>
<ul>
	<li><{$smarty.const._HE_CHESS_NOTATION_040_1|replace:' ':'&nbsp;'}></li>
	<li><{$smarty.const._HE_CHESS_NOTATION_040_2|replace:' ':'&nbsp;'}></li>
	<li><{$smarty.const._HE_CHESS_NOTATION_040_3|replace:' ':'&nbsp;'}></li>
	<li><{$smarty.const._HE_CHESS_NOTATION_040_4|replace:' ':'&nbsp;'}></li>
	<li><{$smarty.const._HE_CHESS_NOTATION_040_5|replace:' ':'&nbsp;'}></li>
	<li><{$smarty.const._HE_CHESS_NOTATION_040_6|replace:' ':'&nbsp;'}></li>
	<li><{$smarty.const._HE_CHESS_NOTATION_040_7|replace:' ':'&nbsp;'}></li>
</ul>
</td></tr>

<tr><td class="odd">
<{$smarty.const._HE_CHESS_NOTATION_050}>
</td></tr>

<tr><td class="odd">
<{$smarty.const._HE_CHESS_NOTATION_060}>
</td></tr>

<tr><td class="odd">
<{$smarty.const._HE_CHESS_NOTATION_070}>
</td></tr>

<{* -------------------- *}>

<tr><td class="head">
<{$smarty.const._HE_CHESS_EXPORT_TITLE}>
</td></tr>

<tr><td class="odd">
<{$smarty.const._HE_CHESS_EXPORT_010}>
</td></tr>

<{* -------------------- *}>

<tr><td class="head">
<{$smarty.const._HE_CHESS_MISC_TITLE}>
</td></tr>

<tr><td class="odd">
<{$smarty.const._HE_CHESS_MISC_010}>
<br /><br />
<div style="text-align:center">
<img src="images/stalemate.png" alt="<{$smarty.const._HE_CHESS_MISC_010_IMAGE}>" width="165" height="162" border="0" />
</div>
</td></tr>

<tr><td class="odd">
<{$smarty.const._HE_CHESS_MISC_020}>
</td></tr>

<tr><td class="odd">
<{$smarty.const._HE_CHESS_MISC_030}>
</td></tr>

<{* -------------------- *}>

<{if $chess_is_admin}>

	<tr><td class="head">
	<{$smarty.const._HE_CHESS_ADMIN_TITLE}>
	</td></tr>

	<tr><td class="odd">
	<{$smarty.const._HE_CHESS_ADMIN_010}>
	</td></tr>

	<tr><td class="odd">
	<{$smarty.const._HE_CHESS_ADMIN_020}>
	</td></tr>

	<tr><td class="odd">
	<{$smarty.const._HE_CHESS_ADMIN_030}>
	</td></tr>

	<tr><td class="odd">
	<{$smarty.const._HE_CHESS_ADMIN_040}>
	</td></tr>

	<tr><td class="odd">
	<{$smarty.const._HE_CHESS_ADMIN_050}>
	</td></tr>

<{/if}>

<{* -------------------- *}>

</table>

<a href="#top">Top</a>
