import { CourseEditComponent } from './course/course-edit/course-edit.component';
import { CommonModule } from '@angular/common';
import { PageNotFoundComponent } from './page-not-found/page-not-found.component';
import { CoursesListComponent } from './course/courses-list/courses-list.component';
import { HomeComponent } from './home/home.component';
import { RouterModule, Routes } from "@angular/router";
import { NgModule } from '@angular/core';

const routes: Routes = [
  { path: '', component: HomeComponent, pathMatch: 'full' },
  { path: 'add', loadChildren: () => import('./course/course-add/course-add.module').then(m => m.CourseAddModule) },
  { path: 'edit/:id', component: CourseEditComponent },
  { path: 'list', component: CoursesListComponent, pathMatch: 'full' },
  { path: '**', component: PageNotFoundComponent }
];

@NgModule({
  imports: [
    CommonModule,
    RouterModule.forRoot(routes)
  ],
  exports: [
    RouterModule
  ],
  declarations: []
})

export class AppRoutingModule {}
