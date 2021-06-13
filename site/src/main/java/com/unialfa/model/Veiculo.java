package com.unialfa.model;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.persistence.JoinColumn;
import javax.persistence.ManyToOne;

@Entity
public class Veiculo {

	@Id
	@GeneratedValue(strategy = GenerationType.IDENTITY)
	private Integer id;

	private String modelo;

	/*
	 * Para campo no banco do tipo Year
	 * usar String
	 * 
	 */
	
	@Column(name = "anomodelo")
	private String anoModelo;

	@Column(name = "anofabricacao")
	private String anoFabricacao;

	private Double valor;
	
	
	/*
	 * Para campo no banco do tipo Enum,
	 * usar String passando os valores validos do banco
	 * 
	 */
	private String tipo;

	@Column(name = "fotodestaque")
	private String fotoDestaque;

	@ManyToOne
	@JoinColumn(name = "marca_id")
	private Marca marca;

	@ManyToOne
	@JoinColumn(name = "cor_id")
	private Cor cor;

	@ManyToOne
	@JoinColumn(name = "usuario_id")
	private Usuario usuario;

	private String opcionais;

	public Integer getId() {
		return id;
	}

	public void setId(Integer id) {
		this.id = id;
	}

	public String getModelo() {
		return modelo;
	}

	public void setModelo(String modelo) {
		this.modelo = modelo;
	}

	public String getAnoModelo() {
		return anoModelo;
	}

	public void setAnoModelo(String anoModelo) {
		this.anoModelo = anoModelo;
	}

	public String getAnoFabricacao() {
		return anoFabricacao;
	}

	public void setAnoFabricacao(String anoFabricacao) {
		this.anoFabricacao = anoFabricacao;
	}

	public Double getValor() {
		return valor;
	}

	public void setValor(Double valor) {
		this.valor = valor;
	}

	public String getTipo() {
		return tipo;
	}

	public void setTipo(String tipo) {
		this.tipo = tipo;
	}

	public String getFotoDestaque() {
		return fotoDestaque;
	}

	public void setFotoDestaque(String fotoDestaque) {
		this.fotoDestaque = fotoDestaque;
	}

	public Marca getMarca() {
		return marca;
	}

	public void setMarca(Marca marca) {
		this.marca = marca;
	}

	public Cor getCor() {
		return cor;
	}

	public void setCor(Cor cor) {
		this.cor = cor;
	}

	public Usuario getUsuario() {
		return usuario;
	}

	public void setUsuario(Usuario usuario) {
		this.usuario = usuario;
	}

	public String getOpcionais() {
		return opcionais;
	}

	public void setOpcionais(String opcionais) {
		this.opcionais = opcionais;
	}
}
