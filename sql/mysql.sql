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
    `challenge_id`        INT(10) UNSIGNED                          NOT NULL AUTO_INCREMENT,
    `game_type`           ENUM ('open','user')                      NOT NULL DEFAULT 'open',
    `fen`                 VARCHAR(100)                              NOT NULL DEFAULT '',
    `color_option`        ENUM ('player2','random','white','black') NOT NULL DEFAULT 'player2',
    `notify_move_player1` ENUM ('0','1')                            NOT NULL DEFAULT '0',
    `player1_uid`         MEDIUMINT(8) UNSIGNED                     NOT NULL DEFAULT '0',
    `player2_uid`         MEDIUMINT(8) UNSIGNED                     NOT NULL DEFAULT '0',
    `create_date`         DATETIME                                  NOT NULL ,
    `is_rated`            ENUM ('1','0')                            NOT NULL DEFAULT '1',
    PRIMARY KEY (`challenge_id`),
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
    `game_id`                      INT(10) UNSIGNED                 NOT NULL AUTO_INCREMENT,
    `white_uid`                    MEDIUMINT(8) UNSIGNED            NOT NULL DEFAULT '0',
    `black_uid`                    MEDIUMINT(8) UNSIGNED            NOT NULL DEFAULT '0',
    `create_date`                  DATETIME                         NOT NULL ,
    `start_date`                   DATETIME                         NOT NULL ,
    `last_date`                    DATETIME                         NOT NULL ,
    `fen_piece_placement`          VARCHAR(71)                      NOT NULL DEFAULT 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR',
    `fen_active_color`             ENUM ('w','b')                   NOT NULL DEFAULT 'w',
    `fen_castling_availability`    VARCHAR(4)                       NOT NULL DEFAULT 'KQkq',
    `fen_en_passant_target_square` CHAR(2)                          NOT NULL DEFAULT '-',
    `fen_halfmove_clock`           SMALLINT(5) UNSIGNED             NOT NULL DEFAULT '0',
    `fen_fullmove_number`          SMALLINT(5) UNSIGNED             NOT NULL DEFAULT '1',
    `pgn_fen`                      VARCHAR(100)                     NOT NULL DEFAULT '',
    `pgn_result`                   ENUM ('*','0-1','1-0','1/2-1/2') NOT NULL DEFAULT '*',
    `pgn_movetext`                 TEXT                             ,
    `offer_draw`                   ENUM ('','w','b')                NOT NULL DEFAULT '',
    `suspended`                    TEXT                             ,
    `white_confirm`                ENUM ('0','1')                   NOT NULL DEFAULT '1',
    `black_confirm`                ENUM ('0','1')                   NOT NULL DEFAULT '1',
    `is_rated`                     ENUM ('1','0')                   NOT NULL DEFAULT '1',
    PRIMARY KEY (`game_id`),
    KEY `white_uid` (`white_uid`),
    KEY `black_uid` (`black_uid`),
    KEY `date` (`create_date`, `start_date`, `last_date`),
    KEY `pgn_result` (`pgn_result`),
    KEY `suspended_date` (`suspended`(19)),
    KEY `is_rated` (`is_rated`)
) ENGINE=MyISAM;

# ---------------------------------------------------------

#
# Table structure for table 'xoops_chess_ratings'
#

CREATE TABLE `chess_ratings` (
    `player_uid`  MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
    `rating`      SMALLINT(6) UNSIGNED  NOT NULL DEFAULT '1200',
    `games_won`   SMALLINT(6) UNSIGNED  NOT NULL DEFAULT '0',
    `games_lost`  SMALLINT(6) UNSIGNED  NOT NULL DEFAULT '0',
    `games_drawn` SMALLINT(6) UNSIGNED  NOT NULL DEFAULT '0',
    PRIMARY KEY (`player_uid`),
    KEY `rating` (`rating`),
    KEY `games` (`games_won`, `games_lost`, `games_drawn`)
) ENGINE=MyISAM;
