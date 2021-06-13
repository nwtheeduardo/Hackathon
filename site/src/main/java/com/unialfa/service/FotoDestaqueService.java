package com.unialfa.service;

import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.nio.file.StandardCopyOption;

import org.springframework.stereotype.Service;
import org.springframework.util.StringUtils;
import org.springframework.web.multipart.MultipartFile;

@Service
public class FotoDestaqueService {

	//Constante com o caminho de uma pasta local
	private final String uploadDir = "C:\\Users\\Ranghetti\\Pictures\\image_upload\\";

	public String getUploadDir() {
		return uploadDir;
	}

	// Esse método salva o arquivo em uma pasta local
	public String uploadFotoDestaque(MultipartFile file) {
		try {
			Path path = Paths.get(uploadDir + StringUtils.cleanPath(file.getOriginalFilename()));
			Files.copy(file.getInputStream(), path, StandardCopyOption.REPLACE_EXISTING);

			return file.getOriginalFilename();
		} catch (Exception e) {
			e.printStackTrace();
			return "default.png";
		}
	}

	// Esse método salva o arquivo no projeto a partir da pasta target
	public String uploadFotoDestaqueTarget(MultipartFile file) {
		try {
			String url = getClass().getResource("/static/images_upload").toString();
			url = url.replace("file:/", "");
			Path path = Paths.get(url + "/"
					+ StringUtils.cleanPath(file.getOriginalFilename()));
			byte[] bytes = file.getBytes();
			Files.write(path, bytes);
			
			return file.getOriginalFilename();
		} catch (Exception e) {
			e.printStackTrace();
			return "default.png";
		}
	}
}
