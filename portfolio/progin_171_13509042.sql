-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 30, 2012 at 07:19 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `progin_171_13509042`
--

-- --------------------------------------------------------

--
-- Table structure for table `komentar`
--

CREATE TABLE IF NOT EXISTS `komentar` (
  `id_post` int(4) NOT NULL,
  `username` varchar(20) NOT NULL,
  `isi_komentar` text NOT NULL,
  `waktu_comment` datetime NOT NULL,
  PRIMARY KEY (`id_post`,`username`,`waktu_comment`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `komentar`
--

INSERT INTO `komentar` (`id_post`, `username`, `isi_komentar`, `waktu_comment`) VALUES
(1, 'hanny', '<h3 style=''font-style:italic;''><a href=''profile.php?username=hanny''>hanny</a>  </h3>  <image src=''avatars/IMGP0005 (2).JPG'' height=''50px'' width=''50px''><div>lalalalllaa</div>', '2012-03-26 10:02:52'),
(1, 'hanny', '<h3 style=''font-style:italic;''><a href=''profile.php?username=hanny''>hanny</a>  </h3>  <image src=''avatars/IMGP0005 (2).JPG'' height=''50px'' width=''50px''><div>ini jadi yang pertamax</div>', '2012-03-26 10:02:59'),
(3, 'hanny', '<h3 style=''font-style:italic;''><a href=''profile.php?username=hanny''>hanny</a>  </h3>  <image src=''avatars/IMGP0005 (2).JPG'' height=''50px'' width=''50px''><div>ahahhhaha</div>', '2012-03-26 09:57:38'),
(3, 'hanny', '<h3 style=''font-style:italic;''><a href=''profile.php?username=hanny''>hanny</a>  </h3>  <image src=''avatars/IMGP0005 (2).JPG'' height=''50px'' width=''50px''><div>ufufufuuuufuuu</div>', '2012-03-26 09:57:44'),
(3, 'hanny', '<h3 style=''font-style:italic;''><a href=''profile.php?username=hanny''>hanny</a>  </h3>  <image src=''avatars/IMGP0005 (2).JPG'' height=''50px'' width=''50px''><div>keren banget kan</div>', '2012-03-26 09:57:53'),
(4, 'hanny', '<h3 style=''font-style:italic;''><a href=''profile.html?username=hanny''>hanny</a>  </h3>  <image src=''avatars/IMGP0005 (2).JPG'' height=''50px'' width=''50px''><div>hmmm ayo dicoba</div>', '2012-03-25 00:59:44'),
(5, 'hanny', '<h3 style=''font-style:italic;''><a href=''profile.php?username=hanny''>hanny</a>  </h3>  <image src=''avatars/IMGP0005 (2).JPG'' height=''50px'' width=''50px''><div>weeewwww</div>', '2012-03-26 20:41:30'),
(5, 'hanny', '<h3 style=''font-style:italic;''><a href=''profile.php?username=hanny''>hanny</a>  </h3>  <image src=''avatars/IMGP0005 (2).JPG'' height=''50px'' width=''50px''><div>hahha</div>', '2012-03-26 20:41:40'),
(8, 'hanny', '<h3 style=''font-style:italic;''><a href=''profile.php?username=hanny''>hanny</a>  </h3>  <image src=''avatars/IMGP0005 (2).JPG'' height=''50px'' width=''50px''><div>tes1</div>', '2012-03-26 22:50:32'),
(8, 'hanny', '<h3 style=''font-style:italic;''><a href=''profile.php?username=hanny''>hanny</a>  </h3>  <image src=''avatars/IMGP0005 (2).JPG'' height=''50px'' width=''50px''><div>tes2</div>', '2012-03-26 22:50:38'),
(8, 'hanny', '<h3 style=''font-style:italic;''><a href=''profile.php?username=hanny''>hanny</a>  </h3>  <image src=''avatars/IMGP0005 (2).JPG'' height=''50px'' width=''50px''><div>"tes3"</div>', '2012-03-26 22:50:44');

-- --------------------------------------------------------

--
-- Table structure for table `konten`
--

CREATE TABLE IF NOT EXISTS `konten` (
  `judul` text NOT NULL,
  `id_post` int(4) NOT NULL,
  `username` varchar(20) NOT NULL,
  `isi_konten` text NOT NULL,
  `waktu_dipost` datetime NOT NULL,
  `jumlah_like` int(7) NOT NULL DEFAULT '0',
  `jumlah_dislike` int(7) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_post`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `konten`
--

INSERT INTO `konten` (`judul`, `id_post`, `username`, `isi_konten`, `waktu_dipost`, `jumlah_like`, `jumlah_dislike`) VALUES
('cobain lagi videonya ''_''', 8, 'hanny', '<h1><a href = content.php?idpost=8>cobain lagi videonya "_"</h1><div class="clear"></div><object type="application/x-shockwave-flash" width="600" height="400" data="http://www.youtube.com/v/xXxPf5mGK9Y?version=3*feature=player_detailpage"><param name="movie" value="http://www.youtube.com/v/xXxPf5mGK9Y?version=3*feature=player_detailpage" /><param name="allowFullScreen" value="true" /></object>', '2012-03-26 21:58:44', 1, 1),
('konten tanpa ''tag''', 5, 'hanny', '<h1><a href = "content.php?idpost=5">konten tanpa ''tag''</a></h1><div class="clear"></div><img src="pictures/IMGP0002 (2).JPG" width="100%" /><br />', '2012-03-26 20:37:11', 0, 1),
('image lagi', 6, 'hanny', '<h1><a href = "content.php?idpost=6">image lagi</a></h1><div class="clear"></div><img src="pictures/IMG_1457.JPG" width="100%" /><br />', '2012-03-26 20:49:48', 0, 0),
('post pake ''tag''', 7, 'hanny', '<h1><a href = content.php?idpost=7>post pake "tag"</h1><div class="clear"></div><object type="application/x-shockwave-flash" width ="600" height="400" data="http://www.youtube.com/v/unWbOy164uE?version=3*feature=player_detailpage"><param name="movie" value="http://www.youtube.com/v/unWbOy164uE?version=3*feature=player_detailpage" /><param name="allowFullScreen" value="true" /></object>', '2012-03-26 21:02:29', 2, 0),
('yang ''oke''', 3, 'hanny', '<h1><a href = content.php?idpost=3>cobaaa</h1><div class="clear"></div><a href="ahiiiy">ahiiiy</a><br><div class="clear"></div><h4>mamamiaa<br/><br/><br/><br/>hyhyhy</h4>', '2012-03-25 00:57:04', 0, 1),
('cobaaa', 4, 'hanny', '<h1><a href = content.php?idpost=4>cobaaa</h1><div class="clear"></div><a href="ahiiiy">ahiiiy</a><br><div class="clear"></div><h4>mamamiaa<br/><br/><br/><br/>hyhyhy</h4>', '2012-03-25 00:59:07', 2, 2),
('Post ''pertamax''', 1, 'hanny', '<h1><a href = content.php?idpost=1>Post "pertamax"</h1><div class="clear"></div><a href="http://www.facebook.com/SimSocialFansite?sk=wall">www.facebook.com/SimSocialFansite?sk=wall</a><br><div class="clear"></div><h4>Cobain maen ini dahhh<br/><br/><br/>"ufufuufufuuf"</h4>', '2012-03-24 19:51:57', 0, 0),
('aku ''bisa''', 2, 'hanny', '<h1><a href = content.php?idpost=2>aku "bisa"</h1><div class="clear"></div><a href="hahahhahaah">hahahhahaah</a><br><div class="clear"></div><h4>yakiiinn<br/><br/><br/>pasti bisaaa "w"</h4>', '2012-03-25 00:50:44', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `liker`
--

CREATE TABLE IF NOT EXISTS `liker` (
  `id_post` int(4) NOT NULL,
  `username` varchar(20) NOT NULL,
  `like` enum('like','dislike','netral') NOT NULL DEFAULT 'netral',
  PRIMARY KEY (`id_post`,`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `liker`
--

INSERT INTO `liker` (`id_post`, `username`, `like`) VALUES
(1, 'hanny', 'netral'),
(3, 'hanny', 'netral'),
(4, 'hanny', 'like'),
(3, 'fauzia', 'dislike'),
(4, 'fauzia', 'like'),
(7, 'hanny', 'netral'),
(8, 'hanny', 'like'),
(8, 'mamamia', 'dislike'),
(4, 'mamamia', 'dislike'),
(1, 'mamamia', 'netral'),
(7, 'mamamia', 'like'),
(5, 'fauzia', 'dislike'),
(9, 'fauzia', 'like'),
(7, 'fauzia', 'like');

-- --------------------------------------------------------

--
-- Table structure for table `profil`
--

CREATE TABLE IF NOT EXISTS `profil` (
  `username` varchar(20) NOT NULL,
  `nama_lengkap` varchar(50) NOT NULL,
  `password` varchar(30) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `avatar` text,
  `email` text NOT NULL,
  `gender` enum('Laki-laki','Perempuan') NOT NULL,
  `about_me` text,
  `achievement_post` int(4) NOT NULL DEFAULT '0',
  `achievement_comment` int(4) NOT NULL DEFAULT '0',
  `achievement_like` int(4) NOT NULL DEFAULT '0',
  `achievement_dislike` int(4) NOT NULL DEFAULT '0',
  `jumlah_komentar` int(7) NOT NULL DEFAULT '0',
  `jumlah_konten` int(7) NOT NULL DEFAULT '0',
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `profil`
--

INSERT INTO `profil` (`username`, `nama_lengkap`, `password`, `tanggal_lahir`, `avatar`, `email`, `gender`, `about_me`, `achievement_post`, `achievement_comment`, `achievement_like`, `achievement_dislike`, `jumlah_komentar`, `jumlah_konten`) VALUES
('hanny', 'hanny fauzia', 'fufufufu', '1992-04-13', 'avatars/IMGP0005 (2).JPG', 'ugyaa', 'Perempuan', 'I''m just a simple girl\r\n\r\nwho wants a happy \r\n\r\nand peaceful life', 8, 0, 3, 2, 0, 0),
('fauzia', 'fafauuu ziiiiaaa', 'fufufufu', '1992-04-18', 'avatars/Set Me Free -Fake Art-.jpg', 'lalala@yahoo.com', 'Laki-laki', 'gw keren bet\r\n\r\norang terkeren di dunia!\r\n\r\nfufufufu', 11, 1, 2, 0, 0, 0),
('mamamia', 'mama mia', 'fufufufu', '1993-02-28', 'avatars/DSC_5229.JPG', 'herewego@yahoo.com', 'Perempuan', '', 3, 0, 100, 105, 1, 1),
('cobaa', 'hanny fauzia', 'hahahaha', '1990-03-31', 'avatars/DSC_5229.JPG', 'fufufu@y.co', 'Perempuan', 'lalalallala', 0, 0, 0, 0, 0, 0),
('mumumu', 'mumu gigi', 'hahahahaha', '1993-05-15', 'avatars/IMGP0005 (2).JPG', 'narutoxsasuke_13@yahoo.com', 'Perempuan', 'mugii\r\n\r\n\r\nmuuugiii', 3, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `taglist`
--

CREATE TABLE IF NOT EXISTS `taglist` (
  `id_post` int(3) NOT NULL,
  `tag_name` varchar(100) NOT NULL,
  PRIMARY KEY (`id_post`,`tag_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `taglist`
--

INSERT INTO `taglist` (`id_post`, `tag_name`) VALUES
(7, 'ds'),
(7, 'nintendo'),
(8, 'anime'),
(8, 'ds');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
