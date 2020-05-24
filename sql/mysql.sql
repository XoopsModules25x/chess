# phpMyAdmin SQL Dump
# version 2.6.0-pl1
# http://www.phpmyadmin.net
#
# Host: localhost
# Generation Time: Nov 19, 2005 at 12:24 PM
# Server version: 4.0.21
# PHP Version: 5.0.2
# 
# Database : `xoops`
# 

# --------------------------------------------------------

#
# Table structure for table `xoops_chess_challenges`
#

CREATE TABLE `chess_challenges` (
  `challenge_id` int(10) unsigned NOT NULL auto_increment,
  `game_type` enum('open','user') NOT NULL default 'open',
  `fen` varchar(100) NOT NULL default '',
  `color_option` enum('player2','random','white','black') NOT NULL default 'player2',
  `notify_move_player1` enum('0','1') NOT NULL default '0',
  `player1_uid` mediumint(8) unsigned NOT NULL default '0',
  `player2_uid` mediumint(8) unsigned NOT NULL default '0',
  `create_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `is_rated` enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (`challenge_id`),
  KEY `game_type` (`game_type`),
  KEY `player1_uid` (`player1_uid`),
  KEY `player2_uid` (`player2_uid`),
  KEY `create_date` (`create_date`),
  KEY `is_rated` (`is_rated`)
) ENGINE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `xoops_chess_games`
#

CREATE TABLE `chess_games` (
  `game_id` int(10) unsigned NOT NULL auto_increment,
  `white_uid` mediumint(8) unsigned NOT NULL default '0',
  `black_uid` mediumint(8) unsigned NOT NULL default '0',
  `create_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `start_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `last_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `fen_piece_placement` varchar(71) NOT NULL default 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR',
  `fen_active_color` enum('w','b') NOT NULL default 'w',
  `fen_castling_availability` varchar(4) NOT NULL default 'KQkq',
  `fen_en_passant_target_square` char(2) NOT NULL default '-',
  `fen_halfmove_clock` smallint(5) unsigned NOT NULL default '0',
  `fen_fullmove_number` smallint(5) unsigned NOT NULL default '1',
  `pgn_fen` varchar(100) NOT NULL default '',
  `pgn_result` enum('*','0-1','1-0','1/2-1/2') NOT NULL default '*',
  `pgn_movetext` text NOT NULL,
  `offer_draw` enum('','w','b') NOT NULL default '',
  `suspended` text NOT NULL,
  `white_confirm` enum('0','1') NOT NULL default '1',
  `black_confirm` enum('0','1') NOT NULL default '1',
  `is_rated` enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (`game_id`),
  KEY `white_uid` (`white_uid`),
  KEY `black_uid` (`black_uid`),
  KEY `date` (`create_date`,`start_date`,`last_date`),
  KEY `pgn_result` (`pgn_result`),
  KEY `suspended_date` (`suspended`(19)),
  KEY `is_rated` (`is_rated`)
) ENGINE=MyISAM;

# ---------------------------------------------------------

#
# Table structure for table 'xoops_chess_ratings'
#

CREATE TABLE `chess_ratings` (
  `player_uid` mediumint(8) unsigned NOT NULL default '0',
  `rating` smallint(6) unsigned NOT NULL default '1200',
  `games_won` smallint(6) unsigned NOT NULL default '0',
  `games_lost` smallint(6) unsigned NOT NULL default '0',
  `games_drawn` smallint(6) unsigned NOT NULL default '0',
  PRIMARY KEY  (`player_uid`),
  KEY `rating` (`rating`),
  KEY `games` (`games_won`,`games_lost`,`games_drawn`)
) ENGINE=MyISAM;
