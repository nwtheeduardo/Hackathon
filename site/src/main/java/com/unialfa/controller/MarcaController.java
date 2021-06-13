package com.unialfa.controller;

import javax.websocket.server.PathParam;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestMapping;

import com.unialfa.model.Marca;
import com.unialfa.repository.MarcaRepository;
import com.unialfa.service.LoginService;

@Controller
@RequestMapping("/marca")
public class MarcaController {

	@Autowired
	MarcaRepository repository;
	
	//Serviço de validação usuario logado
	@Autowired
	LoginService login;

	@RequestMapping("lista")
	public String abrirLista(Model model) {
		model.addAttribute("marcas", repository.findAll());

		return login.getIsLogged() ? "marca/lista" : "redirect:/login";
	}

	@GetMapping("/formulario")
	public String abrirFormulario(Marca marca, Model model) {
		
		return login.getIsLogged() ? "marca/formulario" : "redirect:/login";
	}
	
	@GetMapping("/editar")
	public String editar(@PathParam(value = "id") Integer id, Model model) {
		Marca m = repository.getById(id);
		model.addAttribute("marca", m);

		return login.getIsLogged() ? "marca/formulario" : "redirect:/login";
	}
	

	@PostMapping("salvar")
	public String salvar(Marca marca) {
		repository.save(marca);
		return "redirect:lista";
	}

	@PostMapping("editar/salvar")
	public String atualizar(Marca marca) {
		repository.save(marca);
		return "redirect:../lista";
	}

	@GetMapping(value = "excluir")
	public String excluir(@PathParam(value = "id") Integer id) {
		repository.deleteById(id);
		return "redirect:../lista";
	}

}
