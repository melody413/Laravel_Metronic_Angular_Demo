import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CreateLabCategoryComponent } from './create-lab-category.component';

describe('CreateLabCategoryComponent', () => {
  let component: CreateLabCategoryComponent;
  let fixture: ComponentFixture<CreateLabCategoryComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [CreateLabCategoryComponent]
    });
    fixture = TestBed.createComponent(CreateLabCategoryComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
