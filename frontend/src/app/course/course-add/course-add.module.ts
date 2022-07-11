import { CourseAddRoutingModule } from './course-add.routing';
import { ReactiveFormsModule, FormsModule } from '@angular/forms';
import { CourseAddComponent } from './course-add.component';
import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

@NgModule({
  declarations: [
    CourseAddComponent
  ],
  imports: [
    CommonModule,
    CourseAddRoutingModule,
    ReactiveFormsModule,
    FormsModule
  ]
})
export class CourseAddModule { }
