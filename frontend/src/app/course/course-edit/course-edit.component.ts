import { CourseService } from './../../services/course.service';
import { Component, OnInit } from '@angular/core';
import { FormBuilder, Validators } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-course-edit',
  templateUrl: './course-edit.component.html',
  styleUrls: ['./course-edit.component.css']
})
export class CourseEditComponent implements OnInit {

  courseId?: number;

  constructor(
    private formBuilder: FormBuilder,
    private router: Router,
    private courseService: CourseService,
    private url: ActivatedRoute
  ) {
  }

  ngOnInit(): void {
    this.courseId = this.url.snapshot.params['id'];
    if (this.courseId! > 0) {
      this.courseService.findbyId(this.courseId!)
                        .subscribe(
                          (response: any) => {
                            this.updateForm.patchValue(response.data);
                          }
                        );
    }
  }

  updateForm = this.formBuilder.group({
    courseId: [this.courseId],
    courseName: ["", [
      Validators.required,
      Validators.minLength(4)
    ]],
    coursePrice: ["", [
      Validators.required,
      Validators.min(1)
    ]]
  });

  update() {
    this.courseService.update(this.updateForm.value)
                      .subscribe({
                        error: (error) => {
                          console.error(error.message);
                          this.router.navigate(['/list']);
                        },
                        complete: () => this.router.navigate(['/list'])
                      });
    this.updateForm.reset();
  }

}
