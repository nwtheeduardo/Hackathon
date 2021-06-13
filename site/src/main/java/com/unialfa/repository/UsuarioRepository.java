package com.unialfa.repository;

import org.springframework.data.jpa.repository.JpaRepository;

import com.unialfa.model.Usuario;

public interface UsuarioRepository extends JpaRepository<Usuario, Integer> {

	Usuario findByLogin(String login);
	
}
