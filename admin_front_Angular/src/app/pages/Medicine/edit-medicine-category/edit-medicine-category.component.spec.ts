import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EditMedicineCategoryComponent } from './edit-medicine-category.component';

describe('EditMedicineCategoryComponent', () => {
  let component: EditMedicineCategoryComponent;
  let fixture: ComponentFixture<EditMedicineCategoryComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [EditMedicineCategoryComponent]
    });
    fixture = TestBed.createComponent(EditMedicineCategoryComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
