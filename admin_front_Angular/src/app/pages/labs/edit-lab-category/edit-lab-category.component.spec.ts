import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EditLabCategoryComponent } from './edit-lab-category.component';

describe('EditLabCategoryComponent', () => {
  let component: EditLabCategoryComponent;
  let fixture: ComponentFixture<EditLabCategoryComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [EditLabCategoryComponent]
    });
    fixture = TestBed.createComponent(EditLabCategoryComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
