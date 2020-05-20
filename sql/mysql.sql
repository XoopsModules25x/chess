# phpMyAdmin SQL Dump
# version 2.5.6
# http://www.phpmyadmin.net
#
# Host: localhost
# Generation Time: Mar 14, 2004 at 11:42 PM
# Server version: 4.0.13
# PHP Version: 4.3.2
# 
# Database : `xoops_beta`
# 

# --------------------------------------------------------

#
# Table structure for table `xoops_chess_games`
#

CREATE TABLE chess_games (
  game_id int(10) unsigned NOT NULL auto_increment,
  white_uid mediumint(8) unsigned NOT NULL default '0',
  black_uid mediumint(8) unsigned NOT NULL default '0',
  create_date datetime NOT NULL default '0000-00-00 00:00:00',
  start_date datetime NOT NULL default '0000-00-00 00:00:00',
  last_date datetime NOT NULL default '0000-00-00 00:00:00',
  fen_piece_placement varchar(71) NOT NULL default 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR',
  fen_active_color enum('w','b') NOT NULL default 'w',
  fen_castling_availability varchar(4) NOT NULL default 'KQkq',
  fen_en_passant_target_square char(2) NOT NULL default '-',
  fen_halfmove_clock smallint(5) unsigned NOT NULL default '0',
  fen_fullmove_number smallint(5) unsigned NOT NULL default '1',
  pgn_fen varchar(100) NOT NULL default '',
  pgn_result varchar(7) NOT NULL default '*',
  pgn_movetext text NOT NULL,
  offer_draw enum('','w','b') NOT NULL default '',
  suspended text NOT NULL,
  white_confirm enum('0','1') NOT NULL default '1',
  black_confirm enum('0','1') NOT NULL default '1',
  PRIMARY KEY  (game_id)
) ENGINE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `xoops_chess_challenges`
#

CREATE TABLE chess_challenges (
  challenge_id int(10) unsigned NOT NULL auto_increment,
  game_type enum('open','user') NOT NULL default 'open',
  fen varchar(100) NOT NULL default '',
  color_option enum('player2','random','white','black') NOT NULL default 'player2',
  notify_move_player1 enum('0','1') NOT NULL default '0',
  player1_uid mediumint(8) unsigned NOT NULL default '0',
  player2_uid mediumint(8) unsigned NOT NULL default '0',
  create_date datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (challenge_id)
) ENGINE=MyISAM;
