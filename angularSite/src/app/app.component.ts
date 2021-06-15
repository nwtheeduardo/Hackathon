import { HttpClient } from '@angular/common/http';
import { Component } from '@angular/core';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css'],
})
export class AppComponent {
  veiculosNovos: Array<any>;
  veiculosSeminovos: Array<any>;
  todosVeiculos: Array<any>;
  todosVeiculosSave: Array<any>;
  apiURL: string = 'http://localhost:8081/api';
  apiUrlImg :string = 'http://localhost/hackathon/veiculos/';
  imgExtensao = "g.jpg";
  search: string;

  constructor(private http: HttpClient) {
    this.listarVeiculos();
  }

  listarVeiculos() {
    this.http.get(`${this.apiURL}/veiculos`).subscribe((resultado: any) => {
      this.todosVeiculos = resultado;
      this.todosVeiculosSave = resultado;
      this.veiculosNovos = this.todosVeiculos.filter(this.eNovo);
      this.veiculosSeminovos = this.todosVeiculos.filter(this.eSeminovo);
    });
  }

  eNovo(veiculo: any) {
    return veiculo.tipo === 'Novo';
  }
  eSeminovo(veiculo: any) {
    return veiculo.tipo === 'Seminovo';
  }

  filterItems(ev: any) {
    if(this.todosVeiculos){
      if (ev && ev.trim() != '') {
        this.todosVeiculos = this.todosVeiculos.filter((item) => {
          return (item.modelo.toLowerCase().indexOf(ev.toLowerCase()) > -1);
        })
      }else{
        this.todosVeiculos = this.todosVeiculosSave;
         }
    }
  }
}
