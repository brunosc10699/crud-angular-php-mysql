import { Router } from '@angular/router';
import { Component } from '@angular/core';

@Component({
  selector: 'app-search',
  templateUrl: './search.component.html',
  styleUrls: ['./search.component.css']
})
export class SearchComponent {

  search = "";

  constructor(
    private router: Router
  ) {}

  doSearch() {
    if (this.search) {
      this.router.navigate(["list"], { queryParams: { search: this.search } });
      return;
    }
    this.router.navigate(["list"]);
  }

}
