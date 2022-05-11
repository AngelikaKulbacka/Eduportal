-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 12 Cze 2019, 00:19
-- Wersja serwera: 10.1.34-MariaDB
-- Wersja PHP: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `isam`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `administratorzy`
--

CREATE TABLE `administratorzy` (
  `id_administratora` int(11) NOT NULL,
  `login` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `haslo` char(64) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `administratorzy`
--

INSERT INTO `administratorzy` (`id_administratora`, `login`, `haslo`) VALUES
(1, 'admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `lekcja`
--

CREATE TABLE `lekcja` (
  `id_lekcji` int(11) NOT NULL,
  `id_moderatora` int(11) NOT NULL,
  `tytul` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `tresc` text COLLATE utf8_polish_ci NOT NULL,
  `styl` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `lekcja`
--

INSERT INTO `lekcja` (`id_lekcji`, `id_moderatora`, `tytul`, `tresc`, `styl`) VALUES
(42, 1, 'Procesor', 'Tutaj dowiesz siÄ™ o architekturze procesora.', 2),
(43, 1, 'Procesor', 'Tutaj dowiesz siÄ™ wszystkiego o architekturze procesora. Zobaczysz takĹĽe jak poprawnie zamontowaÄ‡ go w komputerze.', 5),
(44, 1, 'PamiÄ™Ä‡ RAM', 'W tej lekcji dowiesz siÄ™ jak dziaĹ‚ajÄ… oraz jak sÄ… zbudowane pamiÄ™ci RAM. Ponadto poznasz odmiany pamiÄ™ci jak i starsze oraz nowsze modele RAMu.', 2),
(45, 1, 'PamiÄ™Ä‡ RAM', 'W tej lekcji dowiesz siÄ™ jak dziaĹ‚a pamiÄ™Ä‡ ram oraz jak umieĹ›ciÄ‡ jÄ… w komputerze.', 2),
(46, 1, 'Karta graficzna', 'W tej lekcji dowiesz siÄ™ jak dziaĹ‚a karta graficzna.  Dowiesz siÄ™ takĹĽe jak prawidĹ‚owo osadziÄ‡ jÄ… w komputerze.', 4);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `lekcjalink`
--

CREATE TABLE `lekcjalink` (
  `id_materialu` int(11) NOT NULL,
  `id_lekcji` int(11) NOT NULL,
  `id_linku` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `lekcjalink`
--

INSERT INTO `lekcjalink` (`id_materialu`, `id_lekcji`, `id_linku`) VALUES
(30, 42, 34),
(31, 43, 35),
(32, 44, 36),
(33, 45, 37),
(34, 46, 38),
(35, 46, 39);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `linki`
--

CREATE TABLE `linki` (
  `id_linku` int(11) NOT NULL,
  `tytul` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `link` varchar(100) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `linki`
--

INSERT INTO `linki` (`id_linku`, `tytul`, `link`) VALUES
(34, 'Procesor PDF', '4735procek.pdf'),
(35, 'MontaĹĽ procesora:', '5542film procesor i radiator.mp4'),
(36, 'RAM PDF:', '2310pamieci.pdf'),
(37, 'Umieszczanie pamiÄ™ci RAM', '7112film ram.mp4'),
(38, 'Karta graficzna PDF', '535grafa.pdf'),
(39, 'Karta graficzna film instruktaĹĽowy:', '4281film graficzna.mp4');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `moderatorzy`
--

CREATE TABLE `moderatorzy` (
  `id_moderatora` int(11) NOT NULL,
  `login` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `haslo` char(64) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `moderatorzy`
--

INSERT INTO `moderatorzy` (`id_moderatora`, `login`, `haslo`) VALUES
(1, 'moderator', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918'),
(4, 'moderator2', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `odpowiedz`
--

CREATE TABLE `odpowiedz` (
  `id_odpowiedzi` int(25) NOT NULL,
  `odpowiedz` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `czy_poprawna` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `odpowiedz`
--

INSERT INTO `odpowiedz` (`id_odpowiedzi`, `odpowiedz`, `czy_poprawna`) VALUES
(17, 'blok ALU', 0),
(18, 'koder liczb zmiennopozycyjnych', 1),
(19, 'ukĹ‚ad sterujÄ…cy', 0),
(20, 'pastÄ™ do butĂłw ', 0),
(21, 'pasztet', 0),
(22, 'pastÄ™ termoprzewodzÄ…cÄ…', 1),
(23, 'PamiÄ™Ä‡ dynamiczna (DIMM)', 1),
(24, 'PamiÄ™Ä‡ statyczna', 0),
(25, 'PamiÄ™Ä‡ flash', 0),
(26, '2', 0),
(27, '4', 0),
(28, '8', 1),
(29, 'VGA', 0),
(30, 'S-Video', 0),
(31, 'HDMI', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pytaniekontrolne`
--

CREATE TABLE `pytaniekontrolne` (
  `id_pyt_odp` int(25) NOT NULL,
  `id_lekcji` int(11) NOT NULL,
  `id_odpowiedzi` int(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `pytaniekontrolne`
--

INSERT INTO `pytaniekontrolne` (`id_pyt_odp`, `id_lekcji`, `id_odpowiedzi`) VALUES
(16, 42, 17),
(17, 42, 18),
(18, 42, 19),
(19, 43, 20),
(20, 43, 21),
(21, 43, 22),
(22, 44, 23),
(23, 44, 24),
(24, 44, 25),
(25, 45, 26),
(26, 45, 27),
(27, 45, 28),
(28, 46, 29),
(29, 46, 30),
(30, 46, 31);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pytanietresc`
--

CREATE TABLE `pytanietresc` (
  `id_lekcji` int(11) NOT NULL,
  `tresc` varchar(250) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `pytanietresc`
--

INSERT INTO `pytanietresc` (`id_lekcji`, `tresc`) VALUES
(42, 'Jednym z podstawowych elementĂłw procesora NIE jest?'),
(43, 'Co umieszczamy na procesorze?'),
(44, 'Jakim typem pamiÄ™ci jest pamiÄ™Ä‡ SDRAM?'),
(45, 'Ile miejsc (SLOTĂ“W) zawiera zaprezentowana na filmie pĹ‚yta gĹ‚Ăłwna?'),
(46, 'Najpopularniejszym obecnie wyjĹ›ciem karty graficznej, mogÄ…cym przesĹ‚aÄ‡ sygnaĹ‚ w jakoĹ›ci 4K jest?');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `style`
--

CREATE TABLE `style` (
  `styl` int(11) NOT NULL,
  `nazwa` varchar(50) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `style`
--

INSERT INTO `style` (`styl`, `nazwa`) VALUES
(1, 'brak'),
(2, 'przyswajanie-wzrokowiec'),
(3, 'przyswajanie-sĹ‚uchowiec'),
(4, 'dziaĹ‚anie-wzrokowiec'),
(5, 'dziaĹ‚anie-sĹ‚uchowiec');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `id_uzytkownika` int(11) NOT NULL,
  `login` varchar(50) CHARACTER SET utf8 NOT NULL,
  `haslo` char(64) CHARACTER SET utf8 NOT NULL,
  `email` varchar(50) CHARACTER SET utf8 NOT NULL,
  `styl` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`id_uzytkownika`, `login`, `haslo`, `email`, `styl`) VALUES
(1, 'user', '04f8996da763b7a969b1028ee3007569eaf3a635486ddab211d512c85b9df8fb', 'user@gmail.com', 3),
(2, 'user2', '6025d18fe48abd45168528f18a82e265dd98d421a7084aa09f61b341703901a3', 'user2@gmail.com', 2),
(3, 'user3', '5860faf02b6bc6222ba5aca523560f0e364ccd8b67bee486fe8bf7c01d492ccb', 'user3@gmail.com', 2),
(4, 'user4', '5269ef980de47819ba3d14340f4665262c41e933dc92c1a27dd5d01b047ac80e', 'user4@gmail.com', 4),
(5, 'user5', '5a39bead318f306939acb1d016647be2e38c6501c58367fdb3e9f52542aa2442', 'user5@gmail.com', 3);

--
-- Indeksy dla zrzutĂłw tabel
--

--
-- Indeksy dla tabeli `administratorzy`
--
ALTER TABLE `administratorzy`
  ADD PRIMARY KEY (`id_administratora`),
  ADD UNIQUE KEY `login_admin` (`login`);

--
-- Indeksy dla tabeli `lekcja`
--
ALTER TABLE `lekcja`
  ADD PRIMARY KEY (`id_lekcji`),
  ADD KEY `styl` (`styl`),
  ADD KEY `id_moderatora` (`id_moderatora`);

--
-- Indeksy dla tabeli `lekcjalink`
--
ALTER TABLE `lekcjalink`
  ADD PRIMARY KEY (`id_materialu`),
  ADD KEY `id_lekcji` (`id_lekcji`),
  ADD KEY `id_linku` (`id_linku`);

--
-- Indeksy dla tabeli `linki`
--
ALTER TABLE `linki`
  ADD PRIMARY KEY (`id_linku`);

--
-- Indeksy dla tabeli `moderatorzy`
--
ALTER TABLE `moderatorzy`
  ADD PRIMARY KEY (`id_moderatora`),
  ADD UNIQUE KEY `login_moderator` (`login`);

--
-- Indeksy dla tabeli `odpowiedz`
--
ALTER TABLE `odpowiedz`
  ADD PRIMARY KEY (`id_odpowiedzi`);

--
-- Indeksy dla tabeli `pytaniekontrolne`
--
ALTER TABLE `pytaniekontrolne`
  ADD PRIMARY KEY (`id_pyt_odp`),
  ADD KEY `id_odpowiedzi` (`id_odpowiedzi`),
  ADD KEY `id_lekcji` (`id_lekcji`);

--
-- Indeksy dla tabeli `pytanietresc`
--
ALTER TABLE `pytanietresc`
  ADD PRIMARY KEY (`id_lekcji`);

--
-- Indeksy dla tabeli `style`
--
ALTER TABLE `style`
  ADD PRIMARY KEY (`styl`);

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`id_uzytkownika`),
  ADD UNIQUE KEY `login_user` (`login`),
  ADD UNIQUE KEY `email_user` (`email`),
  ADD KEY `styl` (`styl`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `administratorzy`
--
ALTER TABLE `administratorzy`
  MODIFY `id_administratora` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT dla tabeli `lekcja`
--
ALTER TABLE `lekcja`
  MODIFY `id_lekcji` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT dla tabeli `lekcjalink`
--
ALTER TABLE `lekcjalink`
  MODIFY `id_materialu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT dla tabeli `linki`
--
ALTER TABLE `linki`
  MODIFY `id_linku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT dla tabeli `moderatorzy`
--
ALTER TABLE `moderatorzy`
  MODIFY `id_moderatora` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `odpowiedz`
--
ALTER TABLE `odpowiedz`
  MODIFY `id_odpowiedzi` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT dla tabeli `pytaniekontrolne`
--
ALTER TABLE `pytaniekontrolne`
  MODIFY `id_pyt_odp` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT dla tabeli `pytanietresc`
--
ALTER TABLE `pytanietresc`
  MODIFY `id_lekcji` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT dla tabeli `style`
--
ALTER TABLE `style`
  MODIFY `styl` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `id_uzytkownika` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ograniczenia dla zrzutĂłw tabel
--

--
-- Ograniczenia dla tabeli `lekcja`
--
ALTER TABLE `lekcja`
  ADD CONSTRAINT `lekcja_ibfk_1` FOREIGN KEY (`styl`) REFERENCES `style` (`styl`);

--
-- Ograniczenia dla tabeli `lekcjalink`
--
ALTER TABLE `lekcjalink`
  ADD CONSTRAINT `lekcjalink_ibfk_1` FOREIGN KEY (`id_linku`) REFERENCES `linki` (`id_linku`),
  ADD CONSTRAINT `lekcjalink_ibfk_2` FOREIGN KEY (`id_lekcji`) REFERENCES `lekcja` (`id_lekcji`);

--
-- Ograniczenia dla tabeli `pytaniekontrolne`
--
ALTER TABLE `pytaniekontrolne`
  ADD CONSTRAINT `pytaniekontrolne_ibfk_3` FOREIGN KEY (`id_lekcji`) REFERENCES `lekcja` (`id_lekcji`),
  ADD CONSTRAINT `pytaniekontrolne_ibfk_4` FOREIGN KEY (`id_odpowiedzi`) REFERENCES `odpowiedz` (`id_odpowiedzi`);

--
-- Ograniczenia dla tabeli `pytanietresc`
--
ALTER TABLE `pytanietresc`
  ADD CONSTRAINT `pytanietresc_ibfk_1` FOREIGN KEY (`id_lekcji`) REFERENCES `lekcja` (`id_lekcji`);

--
-- Ograniczenia dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD CONSTRAINT `uzytkownicy_ibfk_2` FOREIGN KEY (`styl`) REFERENCES `style` (`styl`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
