import { environment } from './../../environments/environment';
import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Course } from '../models/course';

@Injectable({
  providedIn: 'root'
})
export class CourseService {

  constructor(
    private http: HttpClient
  ) { }

  findAll() {
    return this.http.get<Course[]>(environment.API_URL + 'find.php');
  }

  findbyId(courseId: number) {
    return this.http.get<Course>(environment.API_URL + 'find.php?id=' + courseId);
  }

  delete(courseId: number) {
    return this.http.delete(environment.API_URL + 'delete.php?id=' + courseId);
  }

  insert(course: Course) {
    return this.http.post(environment.API_URL + 'insert.php', course);
  }

  update(course: Course) {
    return this.http.put(environment.API_URL + 'update.php', course);
  }

}
