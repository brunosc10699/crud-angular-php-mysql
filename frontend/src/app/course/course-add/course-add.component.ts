import { Course } from 'src/app/models/course';
import { CourseService } from '../../services/course.service';
import { Component } from '@angular/core';
import { FormBuilder, Validators } from '@angular/forms';
import { Router } from '@angular/router';

@Component({
  selector: 'app-course-add',
  templateUrl: './course-add.component.html',
  styleUrls: ['./course-add.component.css']
})
export class CourseAddComponent {

  course?: Course;
  courseName?: string;
  coursePrice?: number;

  constructor(
    private formBuilder: FormBuilder,
    private router: Router,
    private courseService: CourseService,
  ) { }

  insertForm = this.formBuilder.group({
    courseName: ["", [
      Validators.required,
      Validators.minLength(4)
    ]],
    coursePrice: ["", [
      Validators.required,
      Validators.min(1)
    ]]
  });

  insert() {
    this.courseService.insert(this.insertForm.value)
                      .subscribe({
                        error: (error) => {
                          console.error(error.message);
                          this.router.navigate(['/list']);
                        },
                        complete: () => this.router.navigate(['/list'])
                      });
    this.insertForm.reset();
  }
}
