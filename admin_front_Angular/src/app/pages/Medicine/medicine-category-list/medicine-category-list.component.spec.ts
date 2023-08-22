import { ComponentFixture, TestBed } from '@angular/core/testing';

import { MedicineCategoryListComponent } from './medicine-category-list.component';

describe('MedicineCategoryListComponent', () => {
  let component: MedicineCategoryListComponent;
  let fixture: ComponentFixture<MedicineCategoryListComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [MedicineCategoryListComponent]
    });
    fixture = TestBed.createComponent(MedicineCategoryListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
