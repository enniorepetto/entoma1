-- Actualizaciones para la base de datos entoma

-- Actualizar estructura de la tabla publicaciones
ALTER TABLE `publicaciones` 
ADD COLUMN `titulo` VARCHAR(255) DEFAULT NULL AFTER `foto`,
ADD COLUMN `descripcion` TEXT DEFAULT NULL AFTER `titulo`,
ADD COLUMN `etiquetas` VARCHAR(500) DEFAULT NULL AFTER `descripcion`,
ADD COLUMN `ubicacion` VARCHAR(255) DEFAULT NULL AFTER `etiquetas`,
ADD COLUMN `fecha_creacion` TIMESTAMP DEFAULT CURRENT_TIMESTAMP AFTER `ubicacion`,
ADD COLUMN `likes` INT(11) DEFAULT 0 AFTER `fecha_creacion`,
ADD COLUMN `comentarios` INT(11) DEFAULT 0 AFTER `likes`;

-- Crear tabla para likes (opcional para futuras funciones)
CREATE TABLE `likes` (
  `id_like` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_publicacion` int(11) NOT NULL,
  `fecha_like` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_like`),
  UNIQUE KEY `unique_like` (`id_usuario`, `id_publicacion`),
  FOREIGN KEY (`id_usuario`) REFERENCES `usuario`(`id_usuario`) ON DELETE CASCADE,
  FOREIGN KEY (`id_publicacion`) REFERENCES `publicaciones`(`id_publicaciones`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Crear tabla para comentarios (opcional para futuras funciones)
CREATE TABLE `comentarios` (
  `id_comentario` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_publicacion` int(11) NOT NULL,
  `comentario` TEXT NOT NULL,
  `fecha_comentario` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_comentario`),
  FOREIGN KEY (`id_usuario`) REFERENCES `usuario`(`id_usuario`) ON DELETE CASCADE,
  FOREIGN KEY (`id_publicacion`) REFERENCES `publicaciones`(`id_publicaciones`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Crear tabla para posts guardados (opcional)
CREATE TABLE `guardados` (
  `id_guardado` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_publicacion` int(11) NOT NULL,
  `fecha_guardado` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_guardado`),
  UNIQUE KEY `unique_guardado` (`id_usuario`, `id_publicacion`),
  FOREIGN KEY (`id_usuario`) REFERENCES `usuario`(`id_usuario`) ON DELETE CASCADE,
  FOREIGN KEY (`id_publicacion`) REFERENCES `publicaciones`(`id_publicaciones`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Crear tabla para seguidores (opcional)
CREATE TABLE `seguidores` (
  `id_seguimiento` int(11) NOT NULL AUTO_INCREMENT,
  `id_seguidor` int(11) NOT NULL,
  `id_seguido` int(11) NOT NULL,
  `fecha_seguimiento` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_seguimiento`),
  UNIQUE KEY `unique_seguimiento` (`id_seguidor`, `id_seguido`),
  FOREIGN KEY (`id_seguidor`) REFERENCES `usuario`(`id_usuario`) ON DELETE CASCADE,
  FOREIGN KEY (`id_seguido`) REFERENCES `usuario`(`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Agregar algunos datos de ejemplo (opcional)
-- Puedes ejecutar esto solo si quieres datos de prueba
/*
INSERT INTO publicaciones (titulo, descripcion, foto, etiquetas, id_usuario, likes, comentarios) VALUES
('Street Style Casual', 'Look perfecto para un día casual en la ciudad', 'ropaoscura1.jpg', 'street,casual,urbano', 2, 124, 8),
('Elegante para la oficina', 'Combinación perfecta para una reunión importante', 'ropaoscura2.jpg', 'elegante,trabajo,formal', 2, 89, 12),
('Look casual viernes', 'Cómodo pero con estilo para el fin de semana', 'ropaoscura3.jpg', 'casual,viernes,relajado', 2, 156, 23);
*/