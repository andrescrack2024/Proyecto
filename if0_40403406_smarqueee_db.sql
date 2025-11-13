-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: sql312.infinityfree.com
-- Tiempo de generación: 13-11-2025 a las 07:51:42
-- Versión del servidor: 11.4.7-MariaDB
-- Versión de PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `if0_40403406_smarqueee_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logs_auditoria`
--

CREATE TABLE `logs_auditoria` (
  `id` int(11) NOT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  `id_usuario_accion` int(11) DEFAULT NULL,
  `usuario_accion` varchar(50) DEFAULT NULL,
  `accion` varchar(100) NOT NULL,
  `detalles` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `logs_auditoria`
--

INSERT INTO `logs_auditoria` (`id`, `fecha`, `id_usuario_accion`, `usuario_accion`, `accion`, `detalles`) VALUES
(1, '2025-11-04 17:14:42', NULL, 'cajero1', 'Login Fallido', 'Intento de login con contraseña incorrecta'),
(2, '2025-11-04 17:15:28', NULL, 'admin_nuevo', 'Login Fallido', 'Intento de login con contraseña incorrecta'),
(3, '2025-11-04 17:15:51', NULL, 'admin_nuevo', 'Login Fallido', 'Intento de login con contraseña incorrecta'),
(4, '2025-11-04 17:16:50', NULL, 'Daniel_02', 'Login Fallido', 'Intento de login con contraseña incorrecta'),
(5, '2025-11-04 17:21:57', 6, 'Sharly', 'Creación Usuario', 'Nuevo usuario: Daniel20, Rol: admin'),
(6, '2025-11-04 17:22:23', NULL, 'Daniel20', 'Login', 'Inicio de sesión exitoso'),
(7, '2025-11-04 17:31:25', NULL, 'admin_nuevo', 'Login Fallido', 'Intento de login con contraseña incorrecta'),
(8, '2025-11-04 17:32:16', NULL, 'superadmin', 'Login Fallido', 'Intento de login con contraseña incorrecta'),
(9, '2025-11-04 17:32:55', NULL, 'Daniel20', 'Admin Limpia Sesión', 'ID Usuario afectado: 5'),
(10, '2025-11-04 17:33:02', NULL, 'Daniel20', 'Admin Limpia Sesión', 'ID Usuario afectado: 7'),
(11, '2025-11-04 17:33:05', NULL, 'Daniel20', 'Admin Limpia Sesión', 'ID Usuario afectado: 4'),
(12, '2025-11-04 17:33:10', NULL, 'Daniel20', 'Admin Limpia Sesión', 'ID Usuario afectado: 6'),
(13, '2025-11-04 17:33:22', NULL, 'cajero1', 'Login Fallido', 'Intento de login con contraseña incorrecta'),
(14, '2025-11-04 17:33:26', NULL, 'Daniel_02', 'Login', 'Inicio de sesión exitoso'),
(15, '2025-11-04 17:34:01', 6, 'Sharly', 'Login', 'Inicio de sesión exitoso'),
(16, '2025-11-04 17:34:11', 6, 'Sharly', 'Logout', 'Cierre de sesión exitoso'),
(17, '2025-11-04 17:34:15', NULL, 'Daniel20', 'Login', 'Inicio de sesión exitoso'),
(18, '2025-11-04 17:38:11', NULL, '10972382828', 'Login Fallido', 'Intento de login con contraseña incorrecta'),
(19, '2025-11-04 17:38:30', NULL, 'Daniel20', 'Turno Generado', 'Cédula: 1234567890 , Turno: C-003'),
(20, '2025-11-04 17:38:38', NULL, 'Daniel20', 'Turno Generado', 'Cédula: 1198253892, Turno: A-007'),
(21, '2025-11-04 17:39:29', 6, 'Sharly', 'Login', 'Inicio de sesión exitoso'),
(22, '2025-11-04 17:40:04', 6, 'Sharly', 'Actualizar Turno: saltado', 'ID Turno: 8'),
(23, '2025-11-04 17:40:09', 6, 'Sharly', 'Llamar Turno', 'Turno: C-003'),
(24, '2025-11-04 17:41:13', NULL, 'Daniel_02', 'Login Fallido', 'Intento de login con contraseña incorrecta'),
(25, '2025-11-04 17:42:30', NULL, '1077998299', 'Login Fallido', 'Intento de login con contraseña incorrecta'),
(26, '2025-11-04 17:42:44', 6, 'Sharly', 'Actualizar Turno: atendido', 'ID Turno: 9'),
(27, '2025-11-04 17:43:39', 6, 'Sharly', 'Creación Usuario', 'Nuevo usuario: Andres12, Rol: admin'),
(28, '2025-11-04 17:43:53', NULL, 'Andres12', 'Login', 'Inicio de sesión exitoso'),
(29, '2025-11-04 17:44:02', NULL, 'Andres12', 'Admin Limpia Sesión', 'ID Usuario afectado: 8'),
(30, '2025-11-04 17:44:05', NULL, 'Andres12', 'Admin Limpia Sesión', 'ID Usuario afectado: 7'),
(31, '2025-11-04 17:44:08', NULL, 'Andres12', 'Admin Limpia Sesión', 'ID Usuario afectado: 6'),
(32, '2025-11-04 17:51:14', NULL, 'Andres12', 'Logout Admin', 'Cierre de sesión de admin'),
(33, '2025-11-04 17:51:23', NULL, 'Daniel_02', 'Login Fallido', 'Intento de login con contraseña incorrecta'),
(34, '2025-11-04 17:51:32', NULL, 'Andres12', 'Login', 'Inicio de sesión exitoso'),
(35, '2025-11-04 17:51:51', NULL, 'Andres12', 'Admin Edita Usuario', 'ID Usuario: 7, Cambios: nombre_completo = ?, usuario = ?, rol = ?, id_caja_asignada = ?'),
(36, '2025-11-04 17:52:04', NULL, 'Andres12', 'Admin Limpia Sesión', 'ID Usuario afectado: 8'),
(37, '2025-11-04 17:52:11', NULL, 'Andres12', 'Logout Admin', 'Cierre de sesión de admin'),
(38, '2025-11-04 17:52:24', NULL, 'Andres12', 'Login', 'Inicio de sesión exitoso'),
(39, '2025-11-04 17:52:36', NULL, 'Andres12', 'Logout Admin', 'Cierre de sesión de admin'),
(40, '2025-11-04 17:54:19', NULL, 'Andres12', 'Login', 'Inicio de sesión exitoso'),
(41, '2025-11-04 17:54:25', NULL, 'Andres12', 'Logout Admin', 'Cierre de sesión de admin'),
(42, '2025-11-04 18:28:28', NULL, 'Daniel_02', 'Login Fallido', 'Intento de login con contraseña incorrecta'),
(43, '2025-11-04 18:28:42', 6, 'Sharly', 'Login', 'Inicio de sesión exitoso'),
(44, '2025-11-04 18:28:45', 6, 'Sharly', 'Llamar Turno', 'Turno: A-007'),
(45, '2025-11-04 18:31:41', 6, 'Sharly', 'Turno Generado', 'Cédula: 1077998299, Turno: C-004'),
(46, '2025-11-04 18:31:46', 6, 'Sharly', 'Turno Generado', 'Cédula: 1077998299, Turno: A-008'),
(47, '2025-11-04 18:31:51', 6, 'Sharly', 'Turno Generado', 'Cédula: 1234567890 , Turno: A-009'),
(48, '2025-11-04 18:31:59', 6, 'Sharly', 'Turno Generado', 'Cédula: 1198253892, Turno: C-005'),
(49, '2025-11-04 18:33:15', 6, 'Sharly', 'Actualizar Turno: saltado', 'ID Turno: 10'),
(50, '2025-11-04 18:33:20', 6, 'Sharly', 'Llamar Turno', 'Turno: C-004'),
(51, '2025-11-04 18:33:59', 6, 'Sharly', 'Actualizar Turno: atendido', 'ID Turno: 11'),
(52, '2025-11-04 18:34:02', 6, 'Sharly', 'Logout', 'Cierre de sesión exitoso'),
(53, '2025-11-04 18:34:14', 5, 'Adriana2', 'Login', 'Inicio de sesión exitoso'),
(54, '2025-11-04 18:34:18', 5, 'Adriana2', 'Llamar Turno', 'Turno: A-008'),
(55, '2025-11-04 18:34:20', 5, 'Adriana2', 'Actualizar Turno: saltado', 'ID Turno: 12'),
(56, '2025-11-04 18:34:21', 5, 'Adriana2', 'Llamar Turno', 'Turno: A-009'),
(57, '2025-11-04 18:34:23', 5, 'Adriana2', 'Actualizar Turno: saltado', 'ID Turno: 13'),
(58, '2025-11-04 18:34:24', 5, 'Adriana2', 'Llamar Turno', 'Turno: C-005'),
(59, '2025-11-04 18:34:26', 5, 'Adriana2', 'Actualizar Turno: saltado', 'ID Turno: 14'),
(60, '2025-11-04 18:37:51', 5, 'Adriana2', 'Turno Generado', 'Cédula: 1234567890 , Turno: A-010'),
(61, '2025-11-04 18:38:27', 5, 'Adriana2', 'Turno Generado', 'Cédula: 10792832034, Turno: C-006'),
(62, '2025-11-04 18:38:32', 5, 'Adriana2', 'Turno Generado', 'Cédula: 1077998299, Turno: A-011'),
(63, '2025-11-04 18:38:36', 5, 'Adriana2', 'Turno Generado', 'Cédula: 1198253892, Turno: C-007'),
(64, '2025-11-04 18:38:47', 5, 'Adriana2', 'Llamar Turno', 'Turno: A-010'),
(65, '2025-11-04 18:39:49', 5, 'Adriana2', 'Actualizar Turno: saltado', 'ID Turno: 15'),
(66, '2025-11-04 18:39:50', 5, 'Adriana2', 'Llamar Turno', 'Turno: C-006'),
(67, '2025-11-04 18:40:57', 5, 'Adriana2', 'Actualizar Turno: saltado', 'ID Turno: 16'),
(68, '2025-11-04 18:40:58', 5, 'Adriana2', 'Llamar Turno', 'Turno: A-011'),
(69, '2025-11-04 18:41:04', 5, 'Adriana2', 'Actualizar Turno: atendido', 'ID Turno: 17'),
(70, '2025-11-04 18:41:07', 5, 'Adriana2', 'Logout', 'Cierre de sesión exitoso'),
(71, '2025-11-04 18:41:13', NULL, 'Daniel_02', 'Login Fallido', 'Intento de login con contraseña incorrecta'),
(72, '2025-11-04 18:41:43', NULL, 'Andres12', 'Login', 'Inicio de sesión exitoso'),
(73, '2025-11-04 18:41:51', NULL, 'Andres12', 'Admin Elimina Usuario', 'ID Usuario eliminado: 7'),
(74, '2025-11-04 18:42:29', NULL, 'Andres12', 'Admin Edita Usuario', 'ID Usuario: 5, Cambios: nombre_completo = ?, usuario = ?, rol = ?, id_caja_asignada = ?'),
(75, '2025-11-04 18:42:45', NULL, 'Andres12', 'Admin Edita Usuario', 'ID Usuario: 8, Cambios: nombre_completo = ?, usuario = ?, rol = ?, id_caja_asignada = ?'),
(76, '2025-11-04 18:42:54', NULL, 'Andres12', 'Admin Edita Usuario', 'ID Usuario: 6, Cambios: nombre_completo = ?, usuario = ?, rol = ?, id_caja_asignada = ?'),
(77, '2025-11-04 18:43:06', 6, 'Sharly', 'Login', 'Inicio de sesión exitoso'),
(78, '2025-11-04 18:43:20', 6, 'Sharly', 'Llamar Turno', 'Turno: C-007'),
(79, '2025-11-04 18:43:51', 6, 'Sharly', 'Turno Generado', 'Cédula: 1077998299, Turno: A-012'),
(80, '2025-11-04 18:43:55', 6, 'Sharly', 'Turno Generado', 'Cédula: 1198253892, Turno: C-008'),
(81, '2025-11-04 18:43:59', 6, 'Sharly', 'Turno Generado', 'Cédula: 10792832034, Turno: A-013'),
(82, '2025-11-04 18:44:04', 6, 'Sharly', 'Turno Generado', 'Cédula: 1077998200, Turno: A-014'),
(83, '2025-11-04 18:44:09', 6, 'Sharly', 'Turno Generado', 'Cédula: 1077998200, Turno: C-009'),
(84, '2025-11-04 18:44:12', 6, 'Sharly', 'Turno Generado', 'Cédula: 1077998200, Turno: C-010'),
(85, '2025-11-04 18:48:30', NULL, 'Daniel20', 'Login Fallido', 'Intento de login con contraseña incorrecta'),
(86, '2025-11-04 18:48:34', NULL, 'Daniel20', 'Login Fallido', 'Intento de login con contraseña incorrecta'),
(87, '2025-11-04 19:02:16', 6, 'Sharly', 'Creación Usuario', 'Nuevo usuario: Adrian, Rol: admin'),
(88, '2025-11-04 19:04:19', 5, 'Adriana2', 'Login', 'Inicio de sesión exitoso'),
(89, '2025-11-04 19:05:18', 5, 'Adriana2', 'Creación Usuario', 'Nuevo usuario: Juan12, Rol: cajero'),
(90, '2025-11-04 19:05:27', 10, 'Juan12', 'Login', 'Inicio de sesión exitoso'),
(91, '2025-11-04 19:05:39', 10, 'Juan12', 'Llamar Turno', 'Turno: A-012'),
(92, '2025-11-04 19:06:00', 10, 'Juan12', 'Actualizar Turno: saltado', 'ID Turno: 19'),
(93, '2025-11-04 19:06:03', 10, 'Juan12', 'Llamar Turno', 'Turno: C-008'),
(94, '2025-11-04 19:06:31', NULL, 'Andres12', 'Login Fallido', 'Intento de login con contraseña incorrecta'),
(95, '2025-11-04 19:06:48', NULL, 'Adrian', 'Login Fallido', 'Intento de login con contraseña incorrecta'),
(96, '2025-11-04 19:12:05', 10, 'Juan12', 'Actualizar Turno: saltado', 'ID Turno: 20'),
(97, '2025-11-04 19:12:07', 10, 'Juan12', 'Llamar Turno', 'Turno: A-013'),
(98, '2025-11-04 19:15:32', 10, 'Juan12', 'Turno Generado', 'Cédula: 1077998299, Turno: C-011'),
(99, '2025-11-04 19:15:44', 10, 'Juan12', 'Actualizar Turno: saltado', 'ID Turno: 21'),
(100, '2025-11-04 19:15:45', 10, 'Juan12', 'Llamar Turno', 'Turno: A-014'),
(101, '2025-11-04 19:16:21', NULL, 'Adrian', 'Login', 'Inicio de sesión exitoso'),
(102, '2025-11-04 19:16:56', NULL, 'Adrian', 'Admin Edita Usuario', 'ID Usuario: 6, Cambios: nombre_completo = ?, usuario = ?, rol = ?, id_caja_asignada = ?'),
(103, '2025-11-04 19:17:10', NULL, 'Adrian', 'Admin Edita Usuario', 'ID Usuario: 5, Cambios: nombre_completo = ?, usuario = ?, rol = ?, id_caja_asignada = ?'),
(104, '2025-11-04 19:17:17', NULL, 'Adrian', 'Admin Edita Usuario', 'ID Usuario: 10, Cambios: nombre_completo = ?, usuario = ?, rol = ?, id_caja_asignada = ?'),
(105, '2025-11-04 19:18:30', NULL, 'Adrian', 'Admin Limpia Sesión', 'ID Usuario afectado: 5'),
(106, '2025-11-04 19:18:34', NULL, 'Adrian', 'Admin Limpia Sesión', 'ID Usuario afectado: 10'),
(107, '2025-11-04 19:18:39', NULL, 'Adrian', 'Admin Limpia Sesión', 'ID Usuario afectado: 6'),
(108, '2025-11-04 19:19:08', 6, 'Sharly', 'Login', 'Inicio de sesión exitoso'),
(109, '2025-11-04 19:22:44', 6, 'Sharly', 'Actualizar Turno: saltado', 'ID Turno: 18'),
(110, '2025-11-04 19:22:51', 6, 'Sharly', 'Llamar Turno', 'Turno: C-009'),
(111, '2025-11-04 19:23:17', 6, 'Sharly', 'Logout', 'Cierre de sesión exitoso'),
(112, '2025-11-04 19:24:42', NULL, 'Sistema', 'Creación Usuario', 'Nuevo usuario: Adrian, Rol: admin'),
(113, '2025-11-04 19:25:14', NULL, 'Adrian', 'Login', 'Inicio de sesión exitoso'),
(114, '2025-11-04 19:28:02', NULL, 'Adrian', 'Logout Admin', 'Cierre de sesión de admin'),
(115, '2025-11-04 19:28:11', 10, 'Juan12', 'Login', 'Inicio de sesión exitoso'),
(116, '2025-11-04 19:28:34', 10, 'Juan12', 'Logout', 'Cierre de sesión exitoso'),
(117, '2025-11-04 19:28:44', 6, 'Sharly', 'Login', 'Inicio de sesión exitoso'),
(118, '2025-11-04 19:29:07', 6, 'Sharly', 'Logout', 'Cierre de sesión exitoso'),
(119, '2025-11-04 19:29:10', 5, 'Adriana2', 'Login', 'Inicio de sesión exitoso'),
(120, '2025-11-04 19:29:12', 5, 'Adriana2', 'Llamar Turno', 'Turno: C-010'),
(121, '2025-11-04 19:29:25', 5, 'Adriana2', 'Logout', 'Cierre de sesión exitoso'),
(122, '2025-11-04 19:29:31', NULL, 'Adrian', 'Login', 'Inicio de sesión exitoso'),
(123, '2025-11-04 19:52:08', NULL, 'Adrian', 'Turno Generado', 'Cédula: 1077998299, Turno: C-012'),
(124, '2025-11-04 19:52:26', NULL, 'Adrian', 'Turno Generado', 'Cédula: 1077998200, Turno: A-015'),
(125, '2025-11-04 20:36:39', NULL, 'Adrian', 'Logout Admin', 'Cierre de sesión de admin'),
(126, '2025-11-04 20:36:47', 6, 'Sharly', 'Login', 'Inicio de sesión exitoso'),
(127, '2025-11-04 20:36:54', 6, 'Sharly', 'Logout', 'Cierre de sesión exitoso'),
(128, '2025-11-04 20:36:59', NULL, 'Adrian', 'Login', 'Inicio de sesión exitoso'),
(129, '2025-11-04 20:37:05', NULL, 'Adrian', 'Logout Admin', 'Cierre de sesión de admin'),
(130, '2025-11-04 20:39:09', NULL, 'Cliente', 'Turno Generado', 'Cédula: 1077998299, Turno: A-016'),
(131, '2025-11-04 20:44:11', 6, 'Sharly', 'Login', 'Inicio de sesión exitoso'),
(132, '2025-11-04 20:44:17', 6, 'Sharly', 'Logout', 'Cierre de sesión exitoso'),
(133, '2025-11-04 20:46:33', NULL, 'Cliente', 'Turno Generado', 'Cédula: 1077998299, Turno: A-017'),
(134, '2025-11-04 20:54:02', NULL, 'Cliente', 'Turno Generado', 'Cédula: 1198253892, Turno: A-018'),
(135, '2025-11-04 21:03:14', NULL, 'Cliente', 'Turno Generado', 'Cédula: 1198253892, Turno: A-019'),
(136, '2025-11-04 21:05:01', NULL, 'Andres12', 'Login Fallido', 'Intento de login con contraseña incorrecta'),
(137, '2025-11-04 21:05:13', NULL, 'Andres12', 'Login Fallido', 'Intento de login con contraseña incorrecta'),
(138, '2025-11-04 21:05:18', NULL, 'Daniel_02', 'Login Fallido', 'Intento de login con contraseña incorrecta'),
(139, '2025-11-04 21:05:32', 6, 'Sharly', 'Login', 'Inicio de sesión exitoso'),
(140, '2025-11-04 21:06:00', 6, 'Sharly', 'Actualizar Turno: saltado', 'ID Turno: 23'),
(141, '2025-11-04 21:06:01', 6, 'Sharly', 'Llamar Turno', 'Turno: C-011'),
(142, '2025-11-04 21:08:47', 6, 'Sharly', 'Turno Generado', 'Cédula: 10877777777, Turno: A-020'),
(143, '2025-11-04 21:09:13', 6, 'Sharly', 'Actualizar Turno: saltado', 'ID Turno: 25'),
(144, '2025-11-04 21:09:14', 6, 'Sharly', 'Llamar Turno', 'Turno: C-012'),
(145, '2025-11-04 21:09:15', 6, 'Sharly', 'Actualizar Turno: saltado', 'ID Turno: 26'),
(146, '2025-11-04 21:09:15', 6, 'Sharly', 'Llamar Turno', 'Turno: A-015'),
(147, '2025-11-04 21:09:16', 6, 'Sharly', 'Actualizar Turno: atendido', 'ID Turno: 27'),
(148, '2025-11-04 21:09:17', 6, 'Sharly', 'Llamar Turno', 'Turno: A-016'),
(149, '2025-11-04 21:09:17', 6, 'Sharly', 'Actualizar Turno: atendido', 'ID Turno: 28'),
(150, '2025-11-04 21:09:18', 6, 'Sharly', 'Llamar Turno', 'Turno: A-017'),
(151, '2025-11-04 21:09:19', 6, 'Sharly', 'Actualizar Turno: saltado', 'ID Turno: 29'),
(152, '2025-11-04 21:09:20', 6, 'Sharly', 'Llamar Turno', 'Turno: A-018'),
(153, '2025-11-04 21:09:21', 6, 'Sharly', 'Actualizar Turno: atendido', 'ID Turno: 30'),
(154, '2025-11-04 21:09:22', 6, 'Sharly', 'Llamar Turno', 'Turno: A-019'),
(155, '2025-11-04 21:09:24', 6, 'Sharly', 'Actualizar Turno: atendido', 'ID Turno: 31'),
(156, '2025-11-04 21:09:25', 6, 'Sharly', 'Llamar Turno', 'Turno: A-020'),
(157, '2025-11-04 21:10:18', 6, 'Sharly', 'Actualizar Turno: atendido', 'ID Turno: 32'),
(158, '2025-11-06 07:34:12', NULL, 'Daniel_02', 'Login Fallido', 'Intento de login con contraseña incorrecta'),
(159, '2025-11-06 07:36:21', NULL, 'Cliente', 'Turno Generado', 'Cédula: 1077998299, Turno: A-001'),
(160, '2025-11-06 07:38:27', NULL, 'Cliente', 'Turno Generado', 'Cédula: 1198253892, Turno: C-001'),
(161, '2025-11-06 07:38:35', NULL, 'Cliente', 'Turno Generado', 'Cédula: 1077998200, Turno: A-002'),
(162, '2025-11-06 07:42:27', NULL, 'Daniel_02', 'Login Fallido', 'Intento de login con contraseña incorrecta'),
(163, '2025-11-06 07:42:39', 5, 'Adriana2', 'Login', 'Inicio de sesión exitoso'),
(164, '2025-11-06 07:51:53', 5, 'Adriana2', 'Logout', 'Cierre de sesión exitoso'),
(165, '2025-11-06 07:52:10', NULL, 'Adrian', 'Login', 'Inicio de sesión exitoso'),
(166, '2025-11-06 07:54:17', NULL, 'Sistema', 'Creación Usuario', 'Nuevo usuario: Juan23, Rol: admin'),
(167, '2025-11-06 07:54:56', NULL, 'camilo23', 'Login Fallido', 'Intento de login con contraseña incorrecta'),
(168, '2025-11-06 07:55:04', NULL, 'Camilo23', 'Login Fallido', 'Intento de login con contraseña incorrecta'),
(169, '2025-11-06 07:55:23', 12, 'Juan23', 'Login', 'Inicio de sesión exitoso'),
(170, '2025-11-06 08:09:33', 12, 'Juan23', 'Turno Generado', 'Cédula: 1077998201, Turno: A-003'),
(171, '2025-11-06 08:14:16', 12, 'Juan23', 'Logout Admin', 'Cierre de sesión de admin'),
(172, '2025-11-06 08:19:26', NULL, 'Cliente', 'Turno Generado', 'Cédula: 1234567899, Turno: A-004'),
(173, '2025-11-11 13:44:22', NULL, 'Cliente', 'Turno Generado', 'Cédula: 1198253892, Turno: A-001'),
(174, '2025-11-11 13:55:11', NULL, 'Cliente', 'Consulta Turnos', 'Cédula consultada: 102'),
(175, '2025-11-11 13:55:18', NULL, 'Cliente', 'Consulta Turnos', 'Cédula consultada: 1077998299'),
(176, '2025-11-11 14:04:05', NULL, 'Cliente', 'Consulta Turnos', 'Cédula consultada: 1077998299'),
(177, '2025-11-11 14:04:50', NULL, 'Cliente', 'Consulta Turnos', 'Cédula consultada: 1077998299'),
(178, '2025-11-11 14:04:51', NULL, 'Cliente', 'Consulta Turnos', 'Cédula consultada: 1077998299'),
(179, '2025-11-11 14:04:59', NULL, 'Cliente', 'Turno Generado', 'Cédula: 1234567890 , Turno: A-002'),
(180, '2025-11-11 14:05:06', NULL, 'Cliente', 'Turno Generado', 'Cédula: 1234567890 , Turno: C-001'),
(181, '2025-11-11 14:14:03', NULL, 'Andres12', 'Login Fallido', 'Intento de login con contraseña incorrecta'),
(182, '2025-11-11 14:14:09', 5, 'Adriana2', 'Login', 'Inicio de sesión exitoso'),
(183, '2025-11-11 14:14:12', 5, 'Adriana2', 'Actualizar Turno: saltado', 'ID Turno: 24'),
(184, '2025-11-11 14:14:20', 5, 'Adriana2', 'Llamar Turno', 'Turno: A-001'),
(185, '2025-11-11 14:14:33', 5, 'Adriana2', 'Actualizar Turno: saltado', 'ID Turno: 38'),
(186, '2025-11-11 14:14:34', 5, 'Adriana2', 'Llamar Turno', 'Turno: A-002'),
(187, '2025-11-11 14:14:46', 5, 'Adriana2', 'Actualizar Turno: saltado', 'ID Turno: 39'),
(188, '2025-11-11 14:14:47', 5, 'Adriana2', 'Llamar Turno', 'Turno: C-001'),
(189, '2025-11-11 14:15:00', 5, 'Adriana2', 'Actualizar Turno: saltado', 'ID Turno: 40'),
(190, '2025-11-11 14:15:17', 5, 'Adriana2', 'Logout', 'Cierre de sesión exitoso'),
(191, '2025-11-11 14:18:40', NULL, 'Juan23', 'Login Fallido', 'Intento de login con contraseña incorrecta'),
(192, '2025-11-11 14:18:46', 12, 'Juan23', 'Login', 'Inicio de sesión exitoso'),
(193, '2025-11-11 14:19:02', 12, 'Juan23', 'Admin Limpia Sesión', 'ID Usuario afectado: 6'),
(194, '2025-11-11 14:19:09', 12, 'Juan23', 'Logout Admin', 'Cierre de sesión de admin'),
(195, '2025-11-11 14:19:15', 12, 'Juan23', 'Login', 'Inicio de sesión exitoso'),
(196, '2025-11-11 14:41:53', 12, 'Juan23', 'Admin Re-encola Turno', 'ID Turno: 40'),
(197, '2025-11-11 14:44:00', 12, 'Juan23', 'Logout Admin', 'Cierre de sesión de admin'),
(198, '2025-11-11 14:44:06', 6, 'Sharly', 'Login', 'Inicio de sesión exitoso'),
(199, '2025-11-11 14:44:14', 6, 'Sharly', 'Logout', 'Cierre de sesión exitoso'),
(200, '2025-11-11 15:17:13', NULL, 'Cliente', 'Consulta Turnos', 'Cédula consultada: 1077998299'),
(201, '2025-11-11 15:20:34', NULL, 'Cliente', 'Consulta Turnos', 'Cédula consultada: 102'),
(202, '2025-11-11 15:20:41', NULL, 'Cliente', 'Consulta Turnos', 'Cédula consultada: 1077998299'),
(203, '2025-11-11 15:20:48', NULL, 'Cliente', 'Consulta Turnos', 'Cédula consultada: 1077998299'),
(204, '2025-11-11 15:21:06', NULL, 'Cliente', 'Consulta Turnos', 'Cédula consultada: 222222'),
(205, '2025-11-11 15:21:13', NULL, 'Cliente', 'Turno Generado', 'Cédula: 10792832034, Turno: A-003'),
(206, '2025-11-11 15:21:25', NULL, 'Cliente', 'Consulta Turnos', 'Cédula consultada: 1077998299'),
(207, '2025-11-11 15:30:35', NULL, 'Daniel20', 'Login Fallido', 'Intento de login con contraseña incorrecta'),
(208, '2025-11-11 15:30:45', 12, 'Juan23', 'Login', 'Inicio de sesión exitoso'),
(209, '2025-11-12 12:32:29', NULL, 'Cliente', 'Turno Generado', 'Cédula: 1077998299, Turno: A-001'),
(210, '2025-11-12 12:33:42', NULL, 'Cliente', 'Turno Generado', 'Cédula: 1077998299, Turno: A-002'),
(211, '2025-11-12 12:37:57', 6, 'Sharly', 'Login', 'Inicio de sesión exitoso'),
(212, '2025-11-12 12:38:07', 6, 'Sharly', 'Llamar Turno', 'Turno: A-001'),
(213, '2025-11-12 12:42:40', 6, 'Sharly', 'Logout', 'Cierre de sesión exitoso'),
(214, '2025-11-12 12:44:28', 12, 'Juan23', 'Login', 'Inicio de sesión exitoso'),
(215, '2025-11-12 15:42:16', 12, 'Juan23', 'Logout Admin', 'Cierre de sesión de admin'),
(216, '2025-11-12 15:56:32', 6, 'Sharly', 'Login', 'Inicio de sesión exitoso'),
(217, '2025-11-12 16:04:16', 6, 'Sharly', 'Logout', 'Cierre de sesión exitoso'),
(218, '2025-11-12 16:04:22', 12, 'Juan23', 'Login', 'Inicio de sesión exitoso'),
(219, '2025-11-12 17:36:10', 12, 'Juan23', 'Logout Admin', 'Cierre de sesión de admin'),
(220, '2025-11-12 17:36:16', NULL, 'Sharly', 'Login Fallido', 'Intento de login con contraseña incorrecta'),
(221, '2025-11-12 17:36:45', NULL, 'Sharly', 'Login Fallido', 'Intento de login con contraseña incorrecta'),
(222, '2025-11-12 17:36:48', NULL, 'Sharly', 'Login Fallido', 'Intento de login con contraseña incorrecta'),
(223, '2025-11-12 17:38:55', 12, 'Juan23', 'Login', 'Inicio de sesión exitoso'),
(224, '2025-11-12 17:39:01', 12, 'Juan23', 'Logout Admin', 'Cierre de sesión de admin'),
(225, '2025-11-12 17:39:12', NULL, 'Sharly', 'Login Fallido', 'Intento de login con contraseña incorrecta'),
(226, '2025-11-12 17:39:16', NULL, 'Sharly', 'Login Fallido', 'Intento de login con contraseña incorrecta'),
(227, '2025-11-12 17:39:17', NULL, 'Sharly', 'Login Fallido', 'Intento de login con contraseña incorrecta'),
(228, '2025-11-12 17:56:50', NULL, 'Cliente', 'Turno Generado', 'Cédula: 1077998299, Turno: A-003'),
(229, '2025-11-12 17:56:59', NULL, 'Cliente', 'Turno Generado', 'Cédula: 1837472, Turno: C-001'),
(230, '2025-11-12 17:57:50', 5, 'Adriana2', 'Login', 'Inicio de sesión exitoso'),
(231, '2025-11-12 17:57:55', 5, 'Adriana2', 'Llamar Turno', 'Turno: A-002'),
(232, '2025-11-12 17:58:04', 5, 'Adriana2', 'Actualizar Turno: atendido', 'ID Turno: 43'),
(233, '2025-11-12 17:58:07', 5, 'Adriana2', 'Llamar Turno', 'Turno: A-003'),
(234, '2025-11-12 17:58:19', 5, 'Adriana2', 'Actualizar Turno: saltado', 'ID Turno: 44'),
(235, '2025-11-12 17:58:26', 5, 'Adriana2', 'Llamar Turno', 'Turno: C-001'),
(236, '2025-11-12 17:58:52', NULL, 'Cliente', 'Turno Generado', 'Cédula: 1077998299, Turno: A-004'),
(237, '2025-11-12 17:58:57', NULL, 'Cliente', 'Turno Generado', 'Cédula: 1234567890 , Turno: C-002'),
(238, '2025-11-12 17:59:03', NULL, 'Cliente', 'Turno Generado', 'Cédula: 10792832034, Turno: C-003'),
(239, '2025-11-12 17:59:11', 5, 'Adriana2', 'Actualizar Turno: atendido', 'ID Turno: 45'),
(240, '2025-11-12 17:59:12', 5, 'Adriana2', 'Llamar Turno', 'Turno: A-004'),
(241, '2025-11-12 18:00:29', 5, 'Adriana2', 'Actualizar Turno: atendido', 'ID Turno: 46'),
(242, '2025-11-12 18:00:43', 5, 'Adriana2', 'Llamar Turno', 'Turno: C-002'),
(243, '2025-11-12 18:01:05', 12, 'Juan23', 'Login', 'Inicio de sesión exitoso'),
(244, '2025-11-12 18:01:11', 5, 'Adriana2', 'Logout', 'Cierre de sesión exitoso'),
(245, '2025-11-12 18:01:15', 12, 'Juan23', 'Logout Admin', 'Cierre de sesión de admin'),
(246, '2025-11-12 18:01:21', 5, 'Adriana2', 'Login', 'Inicio de sesión exitoso'),
(247, '2025-11-12 18:01:40', 5, 'Adriana2', 'Actualizar Turno: saltado', 'ID Turno: 47'),
(248, '2025-11-12 18:02:00', 5, 'Adriana2', 'Llamar Turno', 'Turno: C-003'),
(249, '2025-11-12 18:03:20', 5, 'Adriana2', 'Turno Generado', 'Cédula: 1198253892, Turno: C-004'),
(250, '2025-11-12 18:03:29', 5, 'Adriana2', 'Consulta Turnos', 'Cédula consultada: 1077998299'),
(251, '2025-11-12 18:05:02', 5, 'Adriana2', 'Logout', 'Cierre de sesión exitoso'),
(252, '2025-11-12 18:12:49', 5, 'Adriana2', 'Login', 'Inicio de sesión exitoso'),
(253, '2025-11-12 18:13:28', NULL, 'Cliente', 'Turno Generado', 'Cédula: 19392929, Turno: A-005'),
(254, '2025-11-12 18:21:11', NULL, 'Cliente', 'Turno Generado', 'Cédula: 1568999, Turno: C-005'),
(255, '2025-11-12 18:22:56', 12, 'Juan23', 'Login', 'Inicio de sesión exitoso'),
(256, '2025-11-12 18:23:13', 12, 'Juan23', 'Admin Re-encola Turno', 'ID Turno: 47'),
(257, '2025-11-12 18:23:52', 12, 'Juan23', 'Logout Admin', 'Cierre de sesión de admin'),
(258, '2025-11-12 18:24:08', 10, 'Juan12', 'Login', 'Inicio de sesión exitoso'),
(259, '2025-11-12 18:24:31', 10, 'Juan12', 'Actualizar Turno: atendido', 'ID Turno: 22'),
(260, '2025-11-12 18:24:34', 10, 'Juan12', 'Llamar Turno', 'Turno: C-002'),
(261, '2025-11-12 18:25:13', 10, 'Juan12', 'Actualizar Turno: atendido', 'ID Turno: 47'),
(262, '2025-11-12 18:25:31', 10, 'Juan12', 'Llamar Turno', 'Turno: C-004'),
(263, '2025-11-12 18:33:49', 10, 'Juan12', 'Actualizar Turno: atendido', 'ID Turno: 49'),
(264, '2025-11-12 18:34:53', 10, 'Juan12', 'Llamar Turno', 'Turno: A-005'),
(265, '2025-11-12 19:41:07', NULL, 'Cliente', 'Turno Generado', 'Cédula: 11794002, Turno: A-006'),
(266, '2025-11-12 20:29:38', 5, 'Adriana2', 'Logout', 'Cierre de sesión exitoso'),
(267, '2025-11-12 21:10:25', 5, 'Adriana2', 'Login', 'Inicio de sesión exitoso'),
(268, '2025-11-12 21:10:37', 5, 'Adriana2', 'Logout', 'Cierre de sesión exitoso'),
(269, '2025-11-12 21:10:52', NULL, 'Adriana2', 'Login Fallido', 'Intento de login con contraseña incorrecta'),
(270, '2025-11-12 21:10:54', NULL, 'Adriana2', 'Login Fallido', 'Intento de login con contraseña incorrecta'),
(271, '2025-11-12 21:10:56', NULL, 'Adriana2', 'Login Fallido', 'Intento de login con contraseña incorrecta'),
(272, '2025-11-12 21:14:17', 12, 'Juan23', 'Login', 'Inicio de sesión exitoso'),
(273, '2025-11-12 21:14:38', 12, 'Juan23', 'Admin Limpia Sesión', 'ID Usuario afectado: 10'),
(274, '2025-11-12 21:14:43', 12, 'Juan23', 'Logout Admin', 'Cierre de sesión de admin'),
(275, '2025-11-12 21:16:24', NULL, 'Cliente', 'Turno Generado', 'Cédula: 1077998299, Turno: A-007'),
(276, '2025-11-12 21:16:29', NULL, 'Cliente', 'Turno Generado', 'Cédula: 1077998200, Turno: A-008'),
(277, '2025-11-12 21:16:34', NULL, 'Cliente', 'Turno Generado', 'Cédula: 10792832034, Turno: C-006'),
(278, '2025-11-12 21:16:39', NULL, 'Cliente', 'Turno Generado', 'Cédula: 10792832034, Turno: C-007'),
(279, '2025-11-12 21:16:46', NULL, 'Cliente', 'Consulta Turnos', 'Cédula consultada: 1077998299'),
(280, '2025-11-12 21:18:05', 5, 'Adriana2', 'Login', 'Inicio de sesión exitoso'),
(281, '2025-11-12 21:18:10', 5, 'Adriana2', 'Re-llamar Turno', 'ID Turno: 48 (C-003)'),
(282, '2025-11-12 21:18:18', 5, 'Adriana2', 'Actualizar Turno: atendido', 'ID Turno: 48'),
(283, '2025-11-12 21:18:23', 5, 'Adriana2', 'Llamar Turno', 'Turno: C-005'),
(284, '2025-11-12 21:18:39', 5, 'Adriana2', 'Actualizar Turno: atendido', 'ID Turno: 51'),
(285, '2025-11-12 21:18:41', 5, 'Adriana2', 'Llamar Turno', 'Turno: C-006'),
(286, '2025-11-12 21:18:48', 5, 'Adriana2', 'Actualizar Turno: atendido', 'ID Turno: 55'),
(287, '2025-11-12 21:18:50', 5, 'Adriana2', 'Llamar Turno', 'Turno: C-007'),
(288, '2025-11-12 21:18:54', 5, 'Adriana2', 'Actualizar Turno: atendido', 'ID Turno: 56'),
(289, '2025-11-12 21:21:02', 5, 'Adriana2', 'Logout', 'Cierre de sesión exitoso'),
(290, '2025-11-12 21:21:35', 10, 'Juan12', 'Login', 'Inicio de sesión exitoso'),
(291, '2025-11-12 21:21:47', 10, 'Juan12', 'Logout', 'Cierre de sesión exitoso'),
(292, '2025-11-12 21:21:52', 5, 'Adriana2', 'Login', 'Inicio de sesión exitoso'),
(293, '2025-11-12 21:21:58', 5, 'Adriana2', 'Logout', 'Cierre de sesión exitoso'),
(294, '2025-11-12 21:22:03', 12, 'Juan23', 'Login', 'Inicio de sesión exitoso'),
(295, '2025-11-12 21:22:07', 12, 'Juan23', 'Logout Admin', 'Cierre de sesión de admin'),
(296, '2025-11-12 21:22:21', 10, 'Juan12', 'Login', 'Inicio de sesión exitoso'),
(297, '2025-11-12 21:22:27', 10, 'Juan12', 'Actualizar Turno: atendido', 'ID Turno: 50'),
(298, '2025-11-12 21:22:29', 10, 'Juan12', 'Llamar Turno', 'Turno: A-006'),
(299, '2025-11-12 21:22:31', 10, 'Juan12', 'Actualizar Turno: atendido', 'ID Turno: 52'),
(300, '2025-11-12 21:22:34', 10, 'Juan12', 'Llamar Turno', 'Turno: A-007'),
(301, '2025-11-12 21:22:35', 10, 'Juan12', 'Actualizar Turno: atendido', 'ID Turno: 53'),
(302, '2025-11-12 21:22:37', 10, 'Juan12', 'Llamar Turno', 'Turno: A-008'),
(303, '2025-11-12 21:22:38', 10, 'Juan12', 'Actualizar Turno: atendido', 'ID Turno: 54'),
(304, '2025-11-12 21:23:48', 10, 'Juan12', 'Logout', 'Cierre de sesión exitoso'),
(305, '2025-11-12 21:25:36', 12, 'Juan23', 'Login', 'Inicio de sesión exitoso'),
(306, '2025-11-12 21:34:04', 12, 'Juan23', 'Admin Desbloquea Usuario', 'ID Usuario afectado: 6'),
(307, '2025-11-12 21:34:12', 12, 'Juan23', 'Admin Bloquea Usuario', 'ID Usuario afectado: 5'),
(308, '2025-11-12 21:34:21', 12, 'Juan23', 'Logout Admin', 'Cierre de sesión de admin'),
(309, '2025-11-12 21:36:33', 12, 'Juan23', 'Login', 'Inicio de sesión exitoso'),
(310, '2025-11-12 21:37:18', 12, 'Juan23', 'Admin Desbloquea Usuario', 'ID Usuario afectado: 5'),
(311, '2025-11-12 21:39:47', 5, 'Adriana2', 'Login', 'Inicio de sesión exitoso'),
(312, '2025-11-12 21:39:50', 5, 'Adriana2', 'Logout', 'Cierre de sesión exitoso'),
(313, '2025-11-12 21:39:57', 5, 'Adriana2', 'Login', 'Inicio de sesión exitoso'),
(314, '2025-11-12 21:40:01', 5, 'Adriana2', 'Logout', 'Cierre de sesión exitoso'),
(315, '2025-11-12 21:41:45', 12, 'Juan23', 'Logout Admin', 'Cierre de sesión de admin'),
(316, '2025-11-12 21:41:54', 12, 'Juan23', 'Login', 'Inicio de sesión exitoso'),
(317, '2025-11-12 21:51:27', 12, 'Juan23', 'Logout Admin', 'Cierre de sesión de admin'),
(318, '2025-11-12 21:51:59', 5, 'Adriana2', 'Login', 'Inicio de sesión exitoso'),
(319, '2025-11-12 21:52:05', 5, 'Adriana2', 'Logout', 'Cierre de sesión exitoso'),
(320, '2025-11-12 22:05:08', 5, 'Adriana2', 'Login', 'Inicio de sesión exitoso'),
(321, '2025-11-12 22:05:15', 5, 'Adriana2', 'Logout', 'Cierre de sesión exitoso'),
(322, '2025-11-12 22:05:30', 6, 'Sharly', 'Login', 'Inicio de sesión exitoso'),
(323, '2025-11-12 22:05:33', 6, 'Sharly', 'Actualizar Turno: atendido', 'ID Turno: 42'),
(324, '2025-11-12 22:05:43', 6, 'Sharly', 'Logout', 'Cierre de sesión exitoso'),
(325, '2025-11-12 22:07:12', NULL, 'Cliente', 'Turno Generado', 'Cédula: 1077998299, Turno: A-009'),
(326, '2025-11-12 22:07:19', NULL, 'Cliente', 'Turno Generado', 'Cédula: 1198253892, Turno: A-010'),
(327, '2025-11-12 22:07:25', NULL, 'Cliente', 'Turno Generado', 'Cédula: 1077998299, Turno: A-011'),
(328, '2025-11-12 22:07:30', NULL, 'Cliente', 'Turno Generado', 'Cédula: 1077998299, Turno: A-012'),
(329, '2025-11-12 22:07:35', NULL, 'Cliente', 'Turno Generado', 'Cédula: 1077998299, Turno: A-013'),
(330, '2025-11-12 22:07:39', NULL, 'Cliente', 'Turno Generado', 'Cédula: 1077998299, Turno: A-014'),
(331, '2025-11-12 22:07:44', NULL, 'Cliente', 'Turno Generado', 'Cédula: 1234567890 , Turno: C-008'),
(332, '2025-11-12 22:07:49', NULL, 'Cliente', 'Turno Generado', 'Cédula: 1234567890 , Turno: C-009'),
(333, '2025-11-12 22:07:53', NULL, 'Cliente', 'Turno Generado', 'Cédula: 10792832034, Turno: C-010'),
(334, '2025-11-12 22:08:05', NULL, 'Cliente', 'Turno Generado', 'Cédula: 1234567890 , Turno: C-011'),
(335, '2025-11-12 22:08:09', NULL, 'Cliente', 'Turno Generado', 'Cédula: 1077998200, Turno: C-012'),
(336, '2025-11-12 22:08:18', NULL, 'Cliente', 'Turno Generado', 'Cédula: 1077998200, Turno: C-013'),
(337, '2025-11-12 22:08:23', NULL, 'Cliente', 'Turno Generado', 'Cédula: 1077998200, Turno: C-014'),
(338, '2025-11-12 22:08:28', 5, 'Adriana2', 'Login', 'Inicio de sesión exitoso'),
(339, '2025-11-12 22:08:32', 5, 'Adriana2', 'Llamar Turno', 'Turno: C-008'),
(340, '2025-11-12 22:08:51', 5, 'Adriana2', 'Logout', 'Cierre de sesión exitoso'),
(341, '2025-11-12 22:09:11', 6, 'Sharly', 'Login', 'Inicio de sesión exitoso'),
(342, '2025-11-12 22:09:14', 6, 'Sharly', 'Llamar Turno', 'Turno: C-009'),
(343, '2025-11-12 22:10:32', 6, 'Sharly', 'Logout', 'Cierre de sesión exitoso'),
(344, '2025-11-12 22:10:48', 10, 'Juan12', 'Login', 'Inicio de sesión exitoso'),
(345, '2025-11-12 22:10:51', 10, 'Juan12', 'Llamar Turno', 'Turno: A-009'),
(346, '2025-11-12 22:21:11', 10, 'Juan12', 'Actualizar Turno: atendido', 'ID Turno: 57'),
(347, '2025-11-12 22:21:13', 10, 'Juan12', 'Llamar Turno', 'Turno: A-010'),
(348, '2025-11-12 22:23:34', 10, 'Juan12', 'Logout', 'Cierre de sesión exitoso'),
(349, '2025-11-12 22:23:39', 10, 'Juan12', 'Re-llamar Turno', 'ID Turno: 50 (A-005)'),
(350, '2025-11-12 22:23:44', 10, 'Juan12', 'Actualizar Turno: atendido', 'ID Turno: 50'),
(351, '2025-11-12 22:23:50', 10, 'Juan12', 'Actualizar Turno: atendido', 'ID Turno: 58'),
(352, '2025-11-12 22:27:43', 10, 'Juan12', 'Llamar Turno', 'Turno: A-011'),
(353, '2025-11-12 22:27:47', 5, 'Adriana2', 'Login', 'Inicio de sesión exitoso'),
(354, '2025-11-12 22:27:50', 5, 'Adriana2', 'Actualizar Turno: atendido', 'ID Turno: 63'),
(355, '2025-11-12 22:27:51', 5, 'Adriana2', 'Logout', 'Cierre de sesión exitoso'),
(356, '2025-11-12 22:27:58', 10, 'Juan12', 'Login', 'Inicio de sesión exitoso'),
(357, '2025-11-12 22:28:01', 10, 'Juan12', 'Actualizar Turno: atendido', 'ID Turno: 59'),
(358, '2025-11-12 22:28:01', 10, 'Juan12', 'Logout', 'Cierre de sesión exitoso'),
(359, '2025-11-12 22:28:09', 6, 'Sharly', 'Login', 'Inicio de sesión exitoso'),
(360, '2025-11-12 22:28:12', 6, 'Sharly', 'Actualizar Turno: atendido', 'ID Turno: 64'),
(361, '2025-11-12 22:28:17', 6, 'Sharly', 'Logout', 'Cierre de sesión exitoso'),
(362, '2025-11-12 22:46:54', NULL, 'Cliente', 'Consulta Turnos', 'Cédula consultada: 1077998299'),
(363, '2025-11-12 22:46:59', NULL, 'Cliente', 'Turno Generado', 'Cédula: 1077998299, Turno: A-015'),
(364, '2025-11-12 23:02:41', NULL, 'Sistema', 'Creación Usuario', 'Nuevo usuario: Carlos, Rol: cajero'),
(365, '2025-11-12 23:02:54', 12, 'Juan23', 'Login', 'Inicio de sesión exitoso'),
(366, '2025-11-12 23:03:18', 12, 'Juan23', 'Logout Admin', 'Cierre de sesión de admin'),
(367, '2025-11-12 23:03:28', NULL, 'Carlos', 'Login', 'Inicio de sesión exitoso'),
(368, '2025-11-12 23:03:31', NULL, 'Carlos', 'Logout', 'Cierre de sesión exitoso'),
(369, '2025-11-12 23:03:38', NULL, 'Carlos', 'Login', 'Inicio de sesión exitoso'),
(370, '2025-11-12 23:03:40', NULL, 'Carlos', 'Logout', 'Cierre de sesión exitoso'),
(371, '2025-11-12 23:03:47', NULL, 'Carlos', 'Login', 'Inicio de sesión exitoso'),
(372, '2025-11-12 23:03:55', NULL, 'Carlos', 'Logout', 'Cierre de sesión exitoso'),
(373, '2025-11-12 23:04:02', 12, 'Juan23', 'Login', 'Inicio de sesión exitoso'),
(374, '2025-11-12 23:04:13', 12, 'Juan23', 'Admin Elimina Usuario', 'ID Usuario eliminado: 13'),
(375, '2025-11-12 23:13:24', 12, 'Juan23', 'Logout Admin', 'Cierre de sesión de admin'),
(376, '2025-11-12 23:15:37', NULL, 'Sistema', 'Creación Usuario', 'Nuevo usuario: Carlos, Rol: cajero'),
(377, '2025-11-12 23:29:06', 12, 'Juan23', 'Login', 'Inicio de sesión exitoso'),
(378, '2025-11-12 23:29:16', 12, 'Juan23', 'Admin Desbloquea Usuario', 'ID Usuario afectado: 14'),
(379, '2025-11-12 23:45:46', 12, 'Juan23', 'Admin Pone Usuario en Espera', 'ID Usuario afectado: 14'),
(380, '2025-11-12 23:46:01', 12, 'Juan23', 'Logout Admin', 'Cierre de sesión de admin'),
(381, '2025-11-12 23:46:07', NULL, 'Carlos', 'Login', 'Inicio de sesión exitoso'),
(382, '2025-11-12 23:46:11', NULL, 'Carlos', 'Logout', 'Cierre de sesión exitoso'),
(383, '2025-11-12 23:47:28', NULL, 'Sistema', 'Creación Usuario', 'Nuevo usuario: Carlos2, Rol: cajero'),
(384, '2025-11-12 23:49:18', 12, 'Juan23', 'Login', 'Inicio de sesión exitoso'),
(385, '2025-11-12 23:49:34', 12, 'Juan23', 'Admin Bloquea/Rechaza Usuario', 'ID Usuario afectado: 14'),
(386, '2025-11-12 23:49:40', 12, 'Juan23', 'Admin Activa Usuario', 'ID Usuario afectado: 14'),
(387, '2025-11-12 23:49:50', 12, 'Juan23', 'Admin Elimina Usuario', 'ID Usuario eliminado: 14'),
(388, '2025-11-12 23:50:02', 12, 'Juan23', 'Admin Elimina Usuario', 'ID Usuario eliminado: 15'),
(389, '2025-11-12 23:50:14', 12, 'Juan23', 'Logout Admin', 'Cierre de sesión de admin'),
(390, '2025-11-12 23:56:34', NULL, 'Sistema', 'Creación Usuario', 'Nuevo usuario: Marcos, Rol: cajero'),
(391, '2025-11-12 23:57:43', NULL, 'Sistema', 'Creación Usuario', 'Nuevo usuario: Marcos1221, Rol: cajero'),
(392, '2025-11-12 23:57:53', 12, 'Juan23', 'Login', 'Inicio de sesión exitoso'),
(393, '2025-11-12 23:58:04', 12, 'Juan23', 'Admin Elimina Usuario', 'ID Usuario eliminado: 16'),
(394, '2025-11-12 23:58:09', 12, 'Juan23', 'Admin Elimina Usuario', 'ID Usuario eliminado: 17'),
(395, '2025-11-12 23:58:13', 12, 'Juan23', 'Logout Admin', 'Cierre de sesión de admin'),
(396, '2025-11-13 00:08:19', 12, 'Juan23', 'Login', 'Inicio de sesión exitoso'),
(397, '2025-11-13 00:13:27', 12, 'Juan23', 'Logout Admin', 'Cierre de sesión de admin'),
(398, '2025-11-13 01:00:55', NULL, 'Cliente', 'Turno Generado', 'Cédula: 1077998299, Turno: C-001'),
(399, '2025-11-13 01:04:26', 5, 'Adriana2', 'Login', 'Inicio de sesión exitoso'),
(400, '2025-11-13 01:04:29', 5, 'Adriana2', 'Llamar Turno', 'Turno: C-001'),
(401, '2025-11-13 01:06:45', 5, 'Adriana2', 'Logout', 'Cierre de sesión exitoso'),
(402, '2025-11-13 01:10:52', 5, 'Adriana2', 'Login', 'Inicio de sesión exitoso'),
(403, '2025-11-13 01:12:07', 5, 'Adriana2', 'Logout', 'Cierre de sesión exitoso'),
(404, '2025-11-13 01:12:12', 12, 'Juan23', 'Login', 'Inicio de sesión exitoso');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pisos_cajas`
--

CREATE TABLE `pisos_cajas` (
  `id` int(11) NOT NULL,
  `nombre_ubicacion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pisos_cajas`
--

INSERT INTO `pisos_cajas` (`id`, `nombre_ubicacion`) VALUES
(1, 'CAJA 1'),
(2, 'CAJA 2'),
(3, 'PISO 2 - Asesoría');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_atencion`
--

CREATE TABLE `tipos_atencion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `prefijo` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipos_atencion`
--

INSERT INTO `tipos_atencion` (`id`, `nombre`, `prefijo`) VALUES
(1, 'Asesoría', 'A'),
(2, 'Cliente', 'C');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `turnos`
--

CREATE TABLE `turnos` (
  `id` int(11) NOT NULL,
  `cedula` varchar(20) NOT NULL,
  `id_tipo_atencion` int(11) NOT NULL,
  `numero_turno` int(11) NOT NULL,
  `codigo_turno` varchar(10) NOT NULL,
  `estado` enum('espera','atendiendo','atendido','saltado') DEFAULT 'espera',
  `id_usuario_atendio` int(11) DEFAULT NULL,
  `id_caja_atendio` int(11) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  `fecha_atencion` datetime DEFAULT NULL,
  `fecha_fin_atencion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `turnos`
--

INSERT INTO `turnos` (`id`, `cedula`, `id_tipo_atencion`, `numero_turno`, `codigo_turno`, `estado`, `id_usuario_atendio`, `id_caja_atendio`, `fecha_creacion`, `fecha_atencion`, `fecha_fin_atencion`) VALUES
(1, '1077998299', 1, 1, 'A-001', 'saltado', 5, 3, '2025-11-04 14:48:49', '2025-11-04 15:19:09', NULL),
(2, '1077998299', 2, 1, 'C-001', 'saltado', 5, 3, '2025-11-04 14:49:12', '2025-11-04 15:47:22', NULL),
(3, '1077998299', 1, 2, 'A-002', 'saltado', 5, 3, '2025-11-04 15:18:25', '2025-11-04 15:47:27', NULL),
(4, '1077998292', 1, 3, 'A-003', 'saltado', 5, 3, '2025-11-04 15:39:16', '2025-11-04 15:47:29', NULL),
(5, '1077998277', 1, 4, 'A-004', 'saltado', 5, 3, '2025-11-04 15:46:39', '2025-11-04 15:47:31', NULL),
(6, '1077998277', 1, 5, 'A-005', 'saltado', 5, 3, '2025-11-04 15:47:57', '2025-11-04 15:48:54', NULL),
(7, '10784587892', 1, 6, 'A-006', 'saltado', 5, 3, '2025-11-04 15:54:44', '2025-11-04 15:55:48', NULL),
(8, '1234567890 ', 2, 2, 'C-002', 'saltado', 6, 2, '2025-11-04 15:56:28', '2025-11-04 15:58:36', NULL),
(9, '1234567890 ', 2, 3, 'C-003', 'atendido', 6, 2, '2025-11-04 17:38:30', '2025-11-04 17:40:09', '2025-11-04 17:42:44'),
(10, '1198253892', 1, 7, 'A-007', 'saltado', 6, 2, '2025-11-04 17:38:38', '2025-11-04 18:28:45', NULL),
(11, '1077998299', 2, 4, 'C-004', 'atendido', 6, 2, '2025-11-04 18:31:41', '2025-11-04 18:33:20', '2025-11-04 18:33:59'),
(12, '1077998299', 1, 8, 'A-008', 'saltado', 5, 3, '2025-11-04 18:31:46', '2025-11-04 18:34:18', NULL),
(13, '1234567890 ', 1, 9, 'A-009', 'saltado', 5, 3, '2025-11-04 18:31:51', '2025-11-04 18:34:21', NULL),
(14, '1198253892', 2, 5, 'C-005', 'saltado', 5, 3, '2025-11-04 18:31:59', '2025-11-04 18:34:24', NULL),
(15, '1234567890 ', 1, 10, 'A-010', 'saltado', 5, 3, '2025-11-04 18:37:51', '2025-11-04 18:38:47', NULL),
(16, '10792832034', 2, 6, 'C-006', 'saltado', 5, 3, '2025-11-04 18:38:27', '2025-11-04 18:39:50', NULL),
(17, '1077998299', 1, 11, 'A-011', 'atendido', 5, 3, '2025-11-04 18:38:32', '2025-11-04 18:40:58', '2025-11-04 18:41:04'),
(18, '1198253892', 2, 7, 'C-007', 'saltado', 6, 1, '2025-11-04 18:38:36', '2025-11-04 19:22:32', NULL),
(19, '1077998299', 1, 12, 'A-012', 'saltado', 10, 3, '2025-11-04 18:43:51', '2025-11-04 19:05:39', NULL),
(20, '1198253892', 2, 8, 'C-008', 'saltado', 10, 3, '2025-11-04 18:43:55', '2025-11-04 19:06:03', NULL),
(21, '10792832034', 1, 13, 'A-013', 'saltado', 10, 3, '2025-11-04 18:43:59', '2025-11-04 19:12:07', NULL),
(22, '1077998200', 1, 14, 'A-014', 'atendido', 10, 3, '2025-11-04 18:44:04', '2025-11-12 18:24:28', '2025-11-12 18:24:31'),
(23, '1077998200', 2, 9, 'C-009', 'saltado', 6, 1, '2025-11-04 18:44:09', '2025-11-04 19:28:46', NULL),
(24, '1077998200', 2, 10, 'C-010', 'saltado', 5, 2, '2025-11-04 18:44:12', '2025-11-06 07:43:14', NULL),
(25, '1077998299', 2, 11, 'C-011', 'saltado', 6, 1, '2025-11-04 19:15:32', '2025-11-04 21:06:01', NULL),
(26, '1077998299', 2, 12, 'C-012', 'saltado', 6, 1, '2025-11-04 19:52:08', '2025-11-04 21:09:14', NULL),
(27, '1077998200', 1, 15, 'A-015', 'atendido', 6, 1, '2025-11-04 19:52:26', '2025-11-04 21:09:15', '2025-11-04 21:09:16'),
(28, '1077998299', 1, 16, 'A-016', 'atendido', 6, 1, '2025-11-04 20:39:09', '2025-11-04 21:09:17', '2025-11-04 21:09:17'),
(29, '1077998299', 1, 17, 'A-017', 'saltado', 6, 1, '2025-11-04 20:46:33', '2025-11-04 21:09:18', NULL),
(30, '1198253892', 1, 18, 'A-018', 'atendido', 6, 1, '2025-11-04 20:54:02', '2025-11-04 21:09:20', '2025-11-04 21:09:21'),
(31, '1198253892', 1, 19, 'A-019', 'atendido', 6, 1, '2025-11-04 21:03:14', '2025-11-04 21:09:22', '2025-11-04 21:09:24'),
(32, '10877777777', 1, 20, 'A-020', 'atendido', 6, 1, '2025-11-04 21:08:47', '2025-11-04 21:09:25', '2025-11-04 21:10:18'),
(33, '1077998299', 1, 1, 'A-001', 'espera', NULL, NULL, '2025-11-06 07:36:21', NULL, NULL),
(34, '1198253892', 2, 1, 'C-001', 'espera', NULL, NULL, '2025-11-06 07:38:27', NULL, NULL),
(35, '1077998200', 1, 2, 'A-002', 'espera', NULL, NULL, '2025-11-06 07:38:35', NULL, NULL),
(36, '1077998201', 1, 3, 'A-003', 'espera', NULL, NULL, '2025-11-06 08:09:33', NULL, NULL),
(37, '1234567899', 1, 4, 'A-004', 'espera', NULL, NULL, '2025-11-06 08:19:26', NULL, NULL),
(38, '1198253892', 1, 1, 'A-001', 'saltado', 5, 2, '2025-11-11 13:44:22', '2025-11-11 14:14:20', NULL),
(39, '1234567890 ', 1, 2, 'A-002', 'saltado', 5, 2, '2025-11-11 14:04:59', '2025-11-11 14:14:34', NULL),
(40, '1234567890 ', 2, 1, 'C-001', 'espera', NULL, NULL, '2025-11-11 14:05:06', NULL, NULL),
(41, '10792832034', 1, 3, 'A-003', 'espera', NULL, NULL, '2025-11-11 15:21:13', NULL, NULL),
(42, '1077998299', 1, 1, 'A-001', 'atendido', 6, 1, '2025-11-12 12:32:29', '2025-11-12 12:38:07', '2025-11-12 22:05:33'),
(43, '1077998299', 1, 2, 'A-002', 'atendido', 5, 2, '2025-11-12 12:33:42', '2025-11-12 17:58:01', '2025-11-12 17:58:04'),
(44, '1077998299', 1, 3, 'A-003', 'saltado', 5, 2, '2025-11-12 17:56:50', '2025-11-12 17:58:17', NULL),
(45, '1837472', 2, 1, 'C-001', 'atendido', 5, 2, '2025-11-12 17:56:59', '2025-11-12 17:59:10', '2025-11-12 17:59:11'),
(46, '1077998299', 1, 4, 'A-004', 'atendido', 5, 2, '2025-11-12 17:58:52', '2025-11-12 18:00:24', '2025-11-12 18:00:29'),
(47, '1234567890 ', 2, 2, 'C-002', 'atendido', 10, 3, '2025-11-12 17:58:57', '2025-11-12 18:25:11', '2025-11-12 18:25:13'),
(48, '10792832034', 2, 3, 'C-003', 'atendido', 5, 2, '2025-11-12 17:59:03', '2025-11-12 21:18:10', '2025-11-12 21:18:18'),
(49, '1198253892', 2, 4, 'C-004', 'atendido', 10, 3, '2025-11-12 18:03:20', '2025-11-12 18:33:47', '2025-11-12 18:33:49'),
(50, '19392929', 1, 5, 'A-005', 'atendido', 10, 3, '2025-11-12 18:13:28', '2025-11-12 18:34:53', '2025-11-12 22:23:44'),
(51, '1568999', 2, 5, 'C-005', 'atendido', 5, 2, '2025-11-12 18:21:11', '2025-11-12 21:18:23', '2025-11-12 21:18:39'),
(52, '11794002', 1, 6, 'A-006', 'atendido', 10, 3, '2025-11-12 19:41:07', '2025-11-12 21:22:29', '2025-11-12 21:22:31'),
(53, '1077998299', 1, 7, 'A-007', 'atendido', 10, 3, '2025-11-12 21:16:24', '2025-11-12 21:22:34', '2025-11-12 21:22:35'),
(54, '1077998200', 1, 8, 'A-008', 'atendido', 10, 3, '2025-11-12 21:16:29', '2025-11-12 21:22:37', '2025-11-12 21:22:38'),
(55, '10792832034', 2, 6, 'C-006', 'atendido', 5, 2, '2025-11-12 21:16:34', '2025-11-12 21:18:41', '2025-11-12 21:18:48'),
(56, '10792832034', 2, 7, 'C-007', 'atendido', 5, 2, '2025-11-12 21:16:39', '2025-11-12 21:18:50', '2025-11-12 21:18:54'),
(57, '1077998299', 1, 9, 'A-009', 'atendido', 10, 3, '2025-11-12 22:07:12', '2025-11-12 22:10:51', '2025-11-12 22:21:11'),
(58, '1198253892', 1, 10, 'A-010', 'atendido', 10, 3, '2025-11-12 22:07:19', '2025-11-12 22:21:13', '2025-11-12 22:23:50'),
(59, '1077998299', 1, 11, 'A-011', 'atendido', 10, 3, '2025-11-12 22:07:25', '2025-11-12 22:27:43', '2025-11-12 22:28:01'),
(60, '1077998299', 1, 12, 'A-012', 'espera', NULL, NULL, '2025-11-12 22:07:30', NULL, NULL),
(61, '1077998299', 1, 13, 'A-013', 'espera', NULL, NULL, '2025-11-12 22:07:35', NULL, NULL),
(62, '1077998299', 1, 14, 'A-014', 'espera', NULL, NULL, '2025-11-12 22:07:39', NULL, NULL),
(63, '1234567890 ', 2, 8, 'C-008', 'atendido', 5, 2, '2025-11-12 22:07:44', '2025-11-12 22:08:32', '2025-11-12 22:27:50'),
(64, '1234567890 ', 2, 9, 'C-009', 'atendido', 6, 1, '2025-11-12 22:07:49', '2025-11-12 22:09:14', '2025-11-12 22:28:12'),
(65, '10792832034', 2, 10, 'C-010', 'espera', NULL, NULL, '2025-11-12 22:07:53', NULL, NULL),
(66, '1234567890 ', 2, 11, 'C-011', 'espera', NULL, NULL, '2025-11-12 22:08:05', NULL, NULL),
(67, '1077998200', 2, 12, 'C-012', 'espera', NULL, NULL, '2025-11-12 22:08:09', NULL, NULL),
(68, '1077998200', 2, 13, 'C-013', 'espera', NULL, NULL, '2025-11-12 22:08:18', NULL, NULL),
(69, '1077998200', 2, 14, 'C-014', 'espera', NULL, NULL, '2025-11-12 22:08:23', NULL, NULL),
(70, '1077998299', 1, 15, 'A-015', 'espera', NULL, NULL, '2025-11-12 22:46:59', NULL, NULL),
(71, '1077998299', 2, 1, 'C-001', 'atendiendo', 5, 2, '2025-11-13 01:00:55', '2025-11-13 01:04:29', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `nombre_completo` varchar(150) DEFAULT NULL,
  `rol` enum('admin','cajero') NOT NULL DEFAULT 'cajero',
  `estado` enum('activo','bloqueado','pendiente') NOT NULL DEFAULT 'pendiente',
  `intentos_fallidos` int(11) NOT NULL DEFAULT 0,
  `bloqueo_hasta` datetime DEFAULT NULL,
  `suspensiones` int(11) NOT NULL DEFAULT 0,
  `id_caja_asignada` int(11) DEFAULT NULL,
  `session_id` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `password_hash`, `nombre_completo`, `rol`, `estado`, `intentos_fallidos`, `bloqueo_hasta`, `suspensiones`, `id_caja_asignada`, `session_id`) VALUES
(5, 'Adriana2', '$2y$10$LzvPdHGe0JNZC4jpwenm5.3d7T.Pc5WBRFraXoeMjVQ3Z9ZWhF2OK', 'Adriana Fernanda', 'cajero', 'activo', 0, NULL, 0, 2, NULL),
(6, 'Sharly', '$2y$10$Lklj3vS7pb0ToTijFQmVyeRkty1WP.y2Z2Dk3wmGF4sigy2vxq1.O', 'Sharly Andres', 'cajero', 'activo', 0, NULL, 0, 1, NULL),
(10, 'Juan12', '$2y$10$Y8mgYLheh3YaWpT5E7/6Revsr3nEIYUP8350sff06Gl3WfHFr75aO', 'Juan David', 'cajero', 'activo', 0, NULL, 0, 3, NULL),
(12, 'Juan23', '$2y$10$4eVXjrsDVuyqnFmdp.L8NuluG3EQYO.vDQ7Expk5LbXoM3izBsjo.', 'Juan Camilo ', 'admin', 'activo', 0, NULL, 0, NULL, 'bea38c732bc93acf41aef743e78aa81a');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `logs_auditoria`
--
ALTER TABLE `logs_auditoria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario_accion` (`id_usuario_accion`);

--
-- Indices de la tabla `pisos_cajas`
--
ALTER TABLE `pisos_cajas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipos_atencion`
--
ALTER TABLE `tipos_atencion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `turnos`
--
ALTER TABLE `turnos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_tipo_atencion` (`id_tipo_atencion`),
  ADD KEY `id_usuario_atendio` (`id_usuario_atendio`),
  ADD KEY `id_caja_atendio` (`id_caja_atendio`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD KEY `id_caja_asignada` (`id_caja_asignada`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `logs_auditoria`
--
ALTER TABLE `logs_auditoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=405;

--
-- AUTO_INCREMENT de la tabla `pisos_cajas`
--
ALTER TABLE `pisos_cajas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipos_atencion`
--
ALTER TABLE `tipos_atencion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `turnos`
--
ALTER TABLE `turnos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `logs_auditoria`
--
ALTER TABLE `logs_auditoria`
  ADD CONSTRAINT `logs_auditoria_ibfk_1` FOREIGN KEY (`id_usuario_accion`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `turnos`
--
ALTER TABLE `turnos`
  ADD CONSTRAINT `turnos_ibfk_1` FOREIGN KEY (`id_tipo_atencion`) REFERENCES `tipos_atencion` (`id`),
  ADD CONSTRAINT `turnos_ibfk_2` FOREIGN KEY (`id_usuario_atendio`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `turnos_ibfk_3` FOREIGN KEY (`id_caja_atendio`) REFERENCES `pisos_cajas` (`id`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_caja_asignada`) REFERENCES `pisos_cajas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
