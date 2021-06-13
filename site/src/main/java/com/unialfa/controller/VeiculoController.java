package com.unialfa.controller;

import java.io.File;
import java.io.IOException;
import java.nio.file.Files;

import javax.websocket.server.PathParam;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.ResponseBody;
import org.springframework.web.multipart.MultipartFile;

import com.unialfa.model.Cor;
import com.unialfa.model.Usuario;
import com.unialfa.model.Veiculo;
import com.unialfa.repository.MarcaRepository;
import com.unialfa.repository.VeiculoRepository;
import com.unialfa.service.FotoDestaqueService;
import com.unialfa.service.LoginService;

@Controller
@RequestMapping("/veiculo")
public class VeiculoController {

	@Autowired
	VeiculoRepository repository;

	@Autowired
	MarcaRepository repoMarca;
	
	//Serviço de validação usuario logado
	@Autowired
	LoginService login;

	//Serviço criado para gravar as imagens
	@Autowired
	FotoDestaqueService fotoService;

	@RequestMapping("lista")
	public String abrirLista(Model model) {
		model.addAttribute("veiculos", repository.findAll());
		
		return "veiculo/lista";
	}

	@GetMapping("/formulario")
	public String abrirFormulario(Veiculo veiculo, Model model) {
		model.addAttribute("marcas", repoMarca.findAll());

		return login.getIsLogged() ? "veiculo/formulario" : "redirect:/login";
	}
	
	@GetMapping("/editar")
	public String editar(@PathParam(value = "id") Integer id, Model model) {
		Veiculo v = repository.getById(id);
		model.addAttribute("veiculo", v);
		model.addAttribute("marcas", repoMarca.findAll());
		
		return login.getIsLogged() ? "veiculo/formulario" : "redirect:/login";
	}	

	//O arquivo vem como argumento de tipo MultipartFile
	@PostMapping("salvar")
	public String salvar(Veiculo veiculo, MultipartFile imagemFile) {

		// 1ª opção: grava na pasta do projeto
		fotoService.uploadFotoDestaqueTarget(imagemFile);

		// 2ª opção: grava em pasta local e já adiciona o valor no fotoDestaque
		veiculo.setFotoDestaque(fotoService.uploadFotoDestaque(imagemFile));

		// >>>>>>>>>>>>>>>>
		// Ajustar conforme o seu projeto
		// Estou passando fixo apenas para teste
		Cor cor = new Cor();
		cor.setId(1);
		cor.setDescricao("Azul");

		Usuario u = new Usuario();
		u.setId(1);
		u.setLogin("admin");
		u.setNome("Administrador");
		u.setSenha("admin");

		veiculo.setAnoFabricacao("1975");
		veiculo.setCor(cor);
		veiculo.setOpcionais("opcionaios");
		veiculo.setTipo("novo");
		veiculo.setUsuario(u);
		veiculo.setValor(50000.00d);
		// <<<<<<<<<<<<<<<<

		repository.save(veiculo);
		return "redirect:lista";
	}

	@PostMapping("editar/salvar")
	public String atualizar(Veiculo veiculo, MultipartFile imagemFile) {
		// 1ª opção: grava na pasta do projeto
		fotoService.uploadFotoDestaqueTarget(imagemFile);

		// 2ª opção: grava em pasta local e já adiciona o valor no fotoDestaque
		veiculo.setFotoDestaque(fotoService.uploadFotoDestaque(imagemFile));
		
		// >>>>>>>>>>>>>>>>
		// Ajustar conforme o seu projeto
		// Estou passando fixo apenas para teste
		Cor cor = new Cor();
		cor.setId(1);
		cor.setDescricao("Azul");

		Usuario u = new Usuario();
		u.setId(1);
		u.setLogin("admin");
		u.setNome("Administrador");
		u.setSenha("admin");

		veiculo.setAnoFabricacao("1975");
		veiculo.setCor(cor);
		veiculo.setOpcionais("opcionaios");
		veiculo.setTipo("novo");
		veiculo.setUsuario(u);
		veiculo.setValor(50000.00d);
		// <<<<<<<<<<<<<<<<
		
		repository.save(veiculo);
		return "redirect:../lista";
	}

	@GetMapping(value = "excluir")
	public String excluir(@PathParam(value = "id") Integer id) {
		repository.deleteById(id);
		return "redirect:../lista";
	}

	// Esse método reenderisa a imagem, ele devolve a imagem para o .html
	// Exemplo:
	// tag             |      rota     |  variavel | insere o valor na variavel  |
	// <img th:src="@{ | /veiculo/img/ |   {foto}  |   (foto=${v.fotoDestaque})  | }">
	// ***********
	// <img th:src="@{/veiculo/img/{foto}(foto=${v.fotoDestaque})}">
	// ***********
	@GetMapping("/img/{foto}")
	@ResponseBody
	public byte[] reenderizarImagem(@PathVariable("foto") String foto) throws IOException {
		try {
			File fotoArquivo = new File(fotoService.getUploadDir() + foto);
			return Files.readAllBytes(fotoArquivo.toPath());
		} catch (Exception e) {
			return null;
		}
	}

}
