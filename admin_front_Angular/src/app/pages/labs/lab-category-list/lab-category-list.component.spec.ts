import { ComponentFixture, TestBed } from '@angular/core/testing';

import { LabCategoryListComponent } from './lab-category-list.component';

describe('LabCategoryListComponent', () => {
  let component: LabCategoryListComponent;
  let fixture: ComponentFixture<LabCategoryListComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [LabCategoryListComponent]
    });
    fixture = TestBed.createComponent(LabCategoryListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
