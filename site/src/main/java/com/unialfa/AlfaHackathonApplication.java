package com.unialfa;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.CommandLineRunner;
import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;

import com.unialfa.model.Usuario;
import com.unialfa.repository.UsuarioRepository;

@SpringBootApplication
public class AlfaHackathonApplication implements CommandLineRunner {

	public static void main(String[] args) {
		SpringApplication.run(AlfaHackathonApplication.class, args);
	}

	@Override
	public void run(String... args) throws Exception {
		// TODO Auto-generated method stub
		testarBanco();
	}

	@Autowired
	UsuarioRepository repositoryU;
	
	private void testarBanco() {
		// TODO Auto-generated method stub

		Usuario u = new Usuario();
		u.setId(1);
		u.setLogin("admin");
		u.setNome("Administrador");
		u.setSenha("admin");
		repositoryU.save(u);

	}

}
