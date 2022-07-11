import { ActivatedRoute, Router } from '@angular/router';
import { Course } from '../../models/course';
import { CourseService } from '../../services/course.service';
import { Component, EventEmitter, OnInit } from '@angular/core';

@Component({
  selector: 'app-courses-list',
  templateUrl: './courses-list.component.html',
  styleUrls: ['./courses-list.component.css']
})
export class CoursesListComponent implements OnInit {

  courses: Course[] = [];
  records: Course[] = [];
  search: string | undefined;
  rowsAmount: number = 7;
  currentPage: number = 1;

  constructor(
    private courseService: CourseService,
    private route: ActivatedRoute,
    private router: Router
  ) { }

  ngOnInit(): void {
    this.courseService.findAll()
                      .subscribe((response: any) => this.records = response.data);
    this.route.queryParamMap.subscribe(params => {
      this.search = params.get("search")?.toLowerCase();
      if (this.search) {
        this.courses = this.records.filter(course => course.courseName?.toLowerCase().includes(`${this.search}`));
      } else {
        this.findAll();
      }
    });
  }

  findAll() {
    this.courseService.findAll().subscribe(
      (response: any) => this.courses = response.data
    );
  }

  findById(courseId: number) {
    this.courseService.findbyId(courseId)
                      .subscribe(
                        (response: any) => this.courses = response.data
                      );
  }

  delete(course: Course) {
    this.courseService.delete(course.courseId!)
                      .subscribe({
                        error: () => {
                          console.error(console.error);
                        },
                        complete: () => {
                          this.courses = this.courses.filter((element: Course) => element !== course);
                          alert("Curso excluído com sucesso!");
                        }
                      });
  }

}
