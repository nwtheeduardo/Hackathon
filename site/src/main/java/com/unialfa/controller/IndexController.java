package com.unialfa.controller;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestMapping;

import com.unialfa.model.Usuario;
import com.unialfa.repository.MarcaRepository;
import com.unialfa.repository.VeiculoRepository;
import com.unialfa.service.FotoDestaqueService;
import com.unialfa.service.LoginService;

@Controller
public class IndexController {

	@Autowired
	VeiculoRepository repository;
	@Autowired
	LoginService login;
	@Autowired
	MarcaRepository repoMarca;

	//Serviço criado para gravar as imagens
	@Autowired
	FotoDestaqueService fotoService;
	
	@RequestMapping("/")
	public String iniciar(Model model) {
				
		return "index";
	}
	
	@RequestMapping("/login")
	public String abrirLogin(Model model) {
	
		return  login.getIsLogged() ? "redirect:/" : "login";
	}
	
	@PostMapping("/logar")
	public String logar(Usuario user, Model model) {
		login.logar(user);

		return "redirect:/";
	}
	
	@GetMapping("/deslogar")
	public String desLogar(Model model) {
		login.desLogar();
		
		return "redirect:/";
	}	
}
